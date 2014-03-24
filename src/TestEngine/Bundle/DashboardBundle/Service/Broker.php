<?php

namespace TestEngine\Bundle\DashboardBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Broker
{
    /**
     * Pass 401 http response of the server to the client
     */
    public $pass401=false;

    /**
     * Url of SSO server
     * @var string
     */
    public $url = "https://sso.timedoctor.dev/authenticate";
    //public $url = "http://www.ssotest.local/server/sso.php";

    /**
     * My identifier, given by SSO provider.
     * @var string
     */
    public $broker = "LYNX";

    /**
     * My secret word, given by SSO provider.
     * @var string
     */
    public $secret = "klm345";

    /**
     * Need to be shorter than session expire of SSO server
     * @var string
     */
    public $sessionExpire = 1800;

    /**
     * Session hash
     * @var string
     */
    protected $sessionToken;

    /**
     * User info recieved from the server.
     * @var array
     */
    protected $userinfo;


    /**
     * Class constructor
     */
    public function __construct($auto_attach=true)
    {
        $this->cookies   = Request::createFromGlobals()->cookies;
        $this->server    = Request::createFromGlobals()->server;
        $this->session   = new Session();

        var_dump($this->cookies->all());
        $sessionToken = $this->cookies->get('session_token');

        if (isset($sessionToken)) {
            $this->sessionToken = $sessionToken;
        }


        if ($auto_attach && !isset($this->sessionToken)) {
            $serverName = $this->server->get('SERVER_NAME');
            $requestURI = $this->server->get('REQUEST_URI');
            header("Location: " . $this->getAttachUrl() . "&redirect=". urlencode("http://{$serverName}{$requestURI}"), true, 307);
            exit;
        }
    }

    /**
     * Get session token
     *
     * @return string
     */
    public function getSessionToken()
    {
        if (!isset($this->sessionToken)) {
            $this->sessionToken = md5(uniqid(rand(), true));
            setcookie('session_token', $this->sessionToken, time() + $this->sessionExpire);
        }

        return $this->sessionToken;
    }

    /**
     * Generate session id from session key
     *
     * @return string
     */
    protected function getSessionId()
    {
        if (!isset($this->sessionToken)) return null;
        return "SSO-{$this->broker}-{$this->sessionToken}-" . md5('session' . $this->sessionToken . $this->server->get('REMOTE_ADDR') . $this->secret);
    }

    /**
     * Get URL to attach session at SSO server
     *
     * @return string
     */
    public function getAttachUrl()
    {
        $token = $this->getSessionToken();
        $checksum = md5("attach{$token}{$this->server->get('REMOTE_ADDR')}{$this->secret}");
        return "{$this->url}?cmd=attach&broker={$this->broker}&token=$token&checksum=$checksum";
    }


    /**
     * Login at sso server.
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($username=null, $password=null)
    {
        if (!isset($username) && isset($_REQUEST['username'])) $username=$_REQUEST['username'];
        if (!isset($password) && isset($_REQUEST['password'])) $password=$_REQUEST['password'];

        list($ret, $body) = $this->serverCmd('login', array('username'=>$username, 'password'=>$password));

        switch ($ret) {
            case 200: $this->parseInfo($body);
                return 1;
            case 401: if ($this->pass401) header("HTTP/1.1 401 Unauthorized");
                return 0;
            default:  throw new \Exception("SSO failure: The server responded with a $ret status" . (!empty($body) ? ': "' . substr(str_replace("\n", " ", trim(strip_tags($body))), 0, 256) .'".' : '.'));
        }

    }

    /**
     * Logout at sso server.
     */
    public function logout()
    {
        list($ret, $body) = $this->serverCmd('logout');
        if ($ret != 200) {

            throw new \Exception("SSO failure: The server responded with a $ret status" . (!empty($body) ? ': "' . substr(str_replace("\n", " ", trim(strip_tags($body))), 0, 256) .'".' : '.'));
        }

        return true;
    }


    /**
     * Set user info from user XML
     *
     * @param string $xml
     */
    protected function parseInfo($xml)
    {
        $response                   = json_decode($xml, true);
        $this->userinfo['identity'] = $response['result'];
    }

    /**
     * Get user information.
     */
    public function getInfo()
    {
        if (!isset($this->userinfo)) {
            list($ret, $body) = $this->serverCmd('info');

            switch ($ret) {
                case 200: $this->parseInfo($body); break;

                case 401: if ($this->pass401) header("HTTP/1.1 401 Unauthorized");
                    $this->userinfo = false; break;

                default:  throw new \Exception("SSO failure: The server responded with a $ret status" . (!empty($body) ? ': "' . substr(str_replace("\n", " ", trim(strip_tags($body))), 0, 256) .'".' : '.'));
            }
        }

        return $this->userinfo;
    }

    /**
     * Ouput user information as XML
     */
    public function info()
    {
        $this->getInfo();

        if (!$this->userinfo) {
            header("HTTP/1.0 401 Unauthorized");
            echo "Not logged in";
            exit;
        }

        header('Content-type: text/xml; charset=UTF-8');
        echo '<?xml version="1.0" encoding="UTF-8" ?>', "\n";
        echo '<user identity="' . htmlspecialchars($this->userinfo['identity'], ENT_COMPAT, 'UTF-8') . '">', "\n";

        foreach ($this->userinfo as $key=>$value) {
            if ($key == 'identity') continue;
            echo "<$key>", htmlspecialchars($value, ENT_COMPAT, 'UTF-8'), "</$key>", "\n";
        }

        echo '</user>';
    }


    /**
     * Execute on SSO server.
     *
     * @param string $cmd   Command
     * @param array  $vars  Post variables
     * @return array
     */
    protected function serverCmd($cmd, $vars=null)
    {
        $curl = curl_init($this->url . '?cmd=' . urlencode($cmd));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIE, "PHPSESSID=" . $this->getSessionId());

        if (isset($vars)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $body = curl_exec($curl);
 //var_dump($body);
        $ret = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl) != 0) throw new Exception("SSO failure: HTTP request to server failed. " . curl_error($curl));

        return array($ret, $body);
    }
}
