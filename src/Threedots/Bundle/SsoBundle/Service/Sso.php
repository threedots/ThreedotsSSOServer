<?php

/*
 * This file is part of the falgun phantom bundle.
 *
 * (c) Threedots.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Threedots\Bundle\SsoBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Sso
 * @package Threedots\Bundle\SsoBundle\Service
 */
class Sso extends Base
{
    protected $started = false;
    protected $broker  = null;
    protected $brokers = array();



    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->session      = $this->get('session');
        $this->cookies      = Request::createFromGlobals()->cookies;
        $this->server       = Request::createFromGlobals()->server;
        $this->request      = Request::createFromGlobals()->query;
        $this->response     = new Response();
        $this->brokers      = $this->getBrokers();
        $this->ssoLinksRepo = $this->get('ssolinks_repository');
    }

    public function login()
    {
        $this->sessionStart();

        $userName = $this->request->get('username');
        $password = $this->request->get('password');

        if (empty($userName) || empty($password)) {
            $this->failLogin('No username or password specified');
        }

        $userInfo = $this->get('users_repository')->getUserInfoByEmailAndPassword($userName, $password);

        if (!$userInfo) {
            $this->failLogin('Incorrect credentials');
        }

        $this->session->set('user', $userInfo);

        return $this->getUserInfoFromSession();
    }

    public function logout()
    {
        $this->sessionStart();
        $this->response->headers->clearCookie($this->session->getName()); //@todo: how to clear cookie
        $this->session->invalidate();
        $this->get('ssolinks_repository')->removeSSOLinks();

        return true;
    }

    public function attach()
    {
        $this->sessionStart();
        $broker   = $this->request->get('broker');
        $token    = $this->request->get('token');
        $checkSum = $this->request->get('checksum');

        if (empty($broker)) {
            $this->fail("No broker specified");
        }
        if (empty($token)) {
            $this->fail("No token specified");
        }

        if (empty($checkSum) || $this->generateAttachChecksum($broker, $token) != $checkSum) {
            $this->fail("Invalid checksum");
        }

        $ssoLinksRepo = $this->get('ssolinks_repository');
        $sid          = $this->generateSessionId($broker, $token);
        $result       = $ssoLinksRepo->getBySSOCode($sid);

        if (!isset($result['link'])) {

            $attached = $ssoLinksRepo->insertSsoSessionId($sid, $this->session->getId());
            symlink('sess_' . $this->session->getId(), realpath($sid));

            if (!$attached) {
                trigger_error("Failed to attach; Symlink wasn't created.", E_USER_ERROR);
            }

        } else {

            $attached = $ssoLinksRepo->updateSsoSessionId($sid, $this->session->getId());

            if (!$attached) {
                trigger_error("Failed to attach; Link file wasn't created.", E_USER_ERROR);
            }
        }


        $redirectUrl = $this->request->get('redirect');
        if ($redirectUrl) {
            header("Location: " . $redirectUrl, true, 307);
            exit;
        }

        // Output an image specially for AJAX apps
        header("Content-Type: image/png");
        readfile("empty.png");
    }

    protected function sessionStart()
    {
        if ($this->started) {
            return;
        }

        $this->started = true;
        $sessionName   = $this->session->getName();
        $cookieSession = $this->cookies->get($sessionName);

        if (!empty($cookieSession) && preg_match('/^SSO-(\w*+)-(\w*+)-([a-z0-9]*+)$/', $this->cookies->get($sessionName), $matches)) {

            $sessionId    = $this->cookies->get($sessionName);
            $result = $this->get('ssolinks_repository')->getBySSOCode($sessionId);

            if (!empty($result['link'])) {
                $this->session->setId($result['link']);
                $this->session->start();
                $this->cookies->set($sessionName, '');
            } else {
                $this->session->start();
            }

            $clientAddress = $this->session->get('client_addr');

            if (!isset($clientAddress)) {
                $this->session->invalidate();
                $this->fail("Not attached");
            }

            if ($this->generateSessionId($matches[1], $matches[2], $clientAddress) != $sessionId) {
                $this->session->invalidate();
                $this->fail("Invalid session id");
            }

            $this->broker = $matches[1];
            return;
        }

        $this->session->start();

        $clientAddress  = $this->session->get('client_addr');
        $remoteIP       = $this->server->get('REMOTE_ADDR');

        if (isset($clientAddress) && $clientAddress != $remoteIP) {
            $this->session->migrate(true);
        }

        if (!isset($clientAddress)) {

            $this->session->set('client_addr', $remoteIP);
        }
    }

    protected function generateSessionId($broker, $token, $clientAddress = null)
    {
        if (!isset($this->brokers[$broker])) {
            return null;
        }

        if (!isset($clientAddress)) {
            $clientAddress = $this->server->get('REMOTE_ADDR');
        }

        return "SSO-{$broker}-{$token}-" . md5('session' . $token . $clientAddress . $this->brokers[$broker]['secret']);
    }

    protected function generateAttachChecksum($broker, $token)
    {
        if (!isset($this->brokers[$broker])) {
            return null;
        }

        $ip = $this->server->get('REMOTE_ADDR');

        return md5('attach' . $token . $ip . $this->brokers[$broker]['secret']);
    }

    public function getUserInfoFromSession()
    {
        $this->sessionStart();
        $user = $this->session->get('user');

        if (empty($user)) {
            $this->failLogin("Not logged in");
        }

        return $user;
    }

    private function getBrokers()
    {
        $brokers = array();

        $param = $this->container->getParameter('threedots_sso');
        foreach($param['brokers'] as $broker ) {

            foreach($broker as $brokerId => $secret){
                $brokers[$brokerId] = array('secret' => $secret);
            }
        }

        return $brokers;
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
        echo $message;
        exit;
    }
}