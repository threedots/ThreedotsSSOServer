<?php

namespace TestEngine\Bundle\SsoBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SSOServer extends Base
{
    protected $started = false;

    protected $broker = null;

    /**
     * Information of the brokers.
     * This should be data in a database.
     *
     * @var array
     */
    protected static $brokers = array(
        'ALEX'  => array('secret'=>"abc123"),
        'BINCK' => array('secret'=>"xyz789"),
        'UZZA'  => array('secret'=>"rino222"),
        'AJAX'  => array('secret'=>"amsterdam"),
        'LYNX'  => array('secret'=>"klm345"),
    );

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->links_path = sys_get_temp_dir();
    }

    /**
     * Start session and protect against session hijacking
     */
    protected function sessionStart()
    {
        if ($this->started) {
            return;
        }

        $this->started = true;
        $matches       = null;
        $sessionName   = $this->get('session')->getName();

        //$_REQUEST = array_merge($_REQUEST, $_COOKIE);

        if (isset($_COOKIE[$sessionName]) && preg_match('/^SSO-(\w*+)-(\w*+)-([a-z0-9]*+)$/', $_COOKIE[$sessionName], $matches)) {

            $sid    = $_COOKIE[$sessionName];
            $result = $this->get('users_repository')->getBySSOCode($sid);

            if (isset($result['link'])) {

                //$this->get('session')->setId($result['link']);
                $this->get('session')->start();
                $this->cookies->set($sessionName, '');

            } else {

                $this->get('session')->start();
            }

            $clientAddress = $this->get('session')->get('client_addr');
            $clientAddress = '127.0.0.1';
            if (!isset($clientAddress)) {
                //$this->get('session')->invalidate();
                $this->fail("Not attached");
            }

            if ($this->generateSessionId($matches[1], $matches[2], $clientAddress) != $sid) {
                //$this->get('session')->invalidate();
                $this->fail("Invalid session id");
            }

            $this->broker = $matches[1];
            return;
        }

        $this->get('session')->start();

        $clientAddress  = $this->get('session')->get('client_addr');
        $serverArr      = Request::createFromGlobals()->server;
        $remoteIP       = $serverArr->get('REMOTE_ADDR');

        if (isset($clientAddress) && $clientAddress != $remoteIP) {
            $this->get('session')->migrate(true);
        }

        if (!isset($clientAddress)) {

            $this->get('session')->set('client_addr', $remoteIP);
        }
    }

    /**
     * Generate session id from session token
     *
     * @param $broker
     * @param $token
     * @param null $client_address
     * @return string
     */
    protected function generateSessionId($broker, $token, $client_address = null)
    {
        $client_address = '127.0.0.1';

        if (!isset(self::$brokers[$broker])) {
            return null;
        }

        $serverArr = Request::createFromGlobals()->server;
        if (!isset($client_address)) {
            $client_address = $serverArr->get('REMOTE_ADDR');
        }

        return "SSO-{$broker}-{$token}-" . md5('session' . $token . $client_address . self::$brokers[$broker]['secret']);
    }

    /**
     * Generate session id from session token
     *
     * @param $broker
     * @param $token
     * @return string
     */
    protected function generateAttachChecksum($broker, $token)
    {
        if (!isset(self::$brokers[$broker])) {
            return null;
        }

        $serverArr = Request::createFromGlobals()->server;
        $ip = '127.0.0.1';
        return md5('attach' . $token . $ip . self::$brokers[$broker]['secret']);
    }

    /**
     * authenticate
     *
     */
    public function login()
    {
        $this->sessionStart();

        if (empty($_POST['username'])) {
            $this->failLogin("No user specified");
        }

        if (empty($_POST['password'])) {
            $this->failLogin("No password specified");
        }

        $userInfo = $this->get('users_repository')->getUserInfoByEmailAndPassword($_POST['username'], $_POST['password']);

        if( !$userInfo) {
            $this->failLogin("Incorrect credentials");
        }

        $this->get('session')->set('user', $userInfo);

        return $this->getUserInformation();
    }

    public function logout()
    {
        $this->sessionStart();
        $this->get('session')->invalidate();
        unset($_COOKIE);
        $this->get('users_repository')->removeSSOLinks();
        echo 1;
    }

    /**
     * Attach a user session to a broker session
     */
    public function attach()
    {
        $this->sessionStart();

        if (empty($_REQUEST['broker'])) {
            $this->fail("No broker specified");
        }
        if (empty($_REQUEST['token'])) {
            $this->fail("No token specified");
        }

        if (empty($_REQUEST['checksum']) || $this->generateAttachChecksum($_REQUEST['broker'], $_REQUEST['token']) != $_REQUEST['checksum']) {
            $this->fail("Invalid checksum");
        }

        $sid      = $this->generateSessionId($_REQUEST['broker'], $_REQUEST['token']);
        $result   = $this->get('users_repository')->getBySSOCode($sid);
        $userRepo = $this->get('users_repository');

        if (!isset($result['link'])) {

            $attached = $userRepo->insertSsoSessionId($sid, $this->get('session')->getId());
            symlink('sess_' . $this->get('session')->getId(), realpath($sid));

            if (!$attached) {
                trigger_error("Failed to attach; Symlink wasn't created.", E_USER_ERROR);
            }

        } else {

            $attached = $userRepo->updateSsoSessionId($sid, $this->get('session')->getId());

            if (!$attached) {
                trigger_error("Failed to attach; Link file wasn't created.", E_USER_ERROR);
            }
        }


        if (isset($_REQUEST['redirect'])) {
            header("Location: " . $_REQUEST['redirect'], true, 307);
            exit;
        }

        // Output an image specially for AJAX apps
        header("Content-Type: image/png");
        readfile("empty.png");
    }

    public function getUserInformation()
    {
        $this->sessionStart();
        $user = $this->get('session')->get('user');

        if (!isset($user)) {
            $this->failLogin("Not logged in");
        }

        return $user;
    }

    protected function fail($message)
    {
        header("HTTP/1.1 406 Not Acceptable");
        echo $message;
        exit;
    }

   protected function failLogin($message)
    {
        header("HTTP/1.1 401 Unauthorized");
        //echo $message;
        return false;
    }
}