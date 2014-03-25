<?php

namespace TestEngine\Bundle\SsoBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    protected $response;

    public function indexAction()
    {

        $request = $this->getRequest()->query->get('cmd');

        if ($request == 'info') {
            $response = $this->get('sso_server')->getUserInformation();
        }

        if ($request == 'login'){
            $response = $this->get('sso_server')->login();

        }

        if ($request == 'attach') {
            $response = $this->get('sso_server')->attach();
        }

        if ($request == 'logout') {
            $response = $this->get('sso_server')->logout();
        }

        return $this->processResponse(200, array(
            'result' => isset($response) ? $response : 'invalid request'
        ));
    }

    protected function processResponse($statusCode, Array $data)
    {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');

        $this->response->setStatusCode($statusCode);
        $this->response->setContent(json_encode($data));

        return $this->response;
    }
}
