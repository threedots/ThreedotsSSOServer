<?php

/*
 * This file is part of the falgun phantom bundle.
 *
 * (c) Threedots.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Threedots\Bundle\SsoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServerController
 * @package Threedots\Bundle\SsoBundle\Controller
 */
class ServerController extends Controller
{
    /**
     * @var Response
     */
    protected $response;

    public function indexAction(Request $request)
    {
        $result = $this->get('users_repository')->getUserInfoByEmailAndPassword('masudiiuc@gmail.com', '123456');
        var_dump($result); die;
        $param = $request->query->get('cmd');
        $response = $this->get('sso_model')->processRequest($param);

        return $this->processResponse(200, array(
            'result' => isset($response) ? $response : 'invalid request'
        ));

    }

    /**
     * @param $statusCode
     * @param array $data
     * @return Response
     */
    protected function processResponse($statusCode, Array $data)
    {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', 'application/json');

        $this->response->setStatusCode($statusCode);
        $this->response->setContent(json_encode($data));

        return $this->response;
    }
}
