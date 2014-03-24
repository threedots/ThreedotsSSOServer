<?php

namespace TestEngine\Bundle\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

//    public function indexAction()
//    {
//        $request = Request::createFromGlobals();
//
//        if( $request->isMethod('post')){
//            $postData = $this->getRequest()->request->all();
//            echo '<pre/>'; print_r( $postData);
//            $loginData = $this->processLogin($postData);
//
//            if( !$loginData ){
//                die('Sorry! invalid Authentication Information');
//            }
//
//            echo '<pre/>'; print_r( $loginData);
//            die;
//        }
//
//
//        return $this->render('TestEngineDashboardBundle:Default:index.html.twig', array('name' => 'Test Engine'));
//    }
//
//    protected function processLogin($data)
//    {
//        $loginInfo = $this->get('auth_service')->checkLogin($data);
//        return true;
//    }

    public function indexAction()
    {
        $brokerService = $this->get('admin_broker');
        $user = $brokerService->getInfo();

        if ($user){
            var_dump($brokerService->broker);
            var_dump($user);
            die('hello');
        }

        return $this->render('TestEngineDashboardBundle:Default:index.html.twig', array('name' => 'Admin System', 'broker' => $brokerService->broker));
    }

    public function ssoLoginCheckAction()
    {
        $data = $this->getRequest()->request->all();

        if (!$data){
            return $this->redirect('/');
        }
        $userName = $data['username'];
        $password = $data['password'];

        $brokerService = $this->get('admin_broker');

        if ($brokerService->login($userName, $password)) {
            header('Location: /', true, 303);
            exit;
        }
    }

    public function logoutAction()
    {
        $brokerService = $this->get('admin_broker');
        $isLogout = $brokerService->logout();

        if ($isLogout){
            return $this->redirect('/');
        }
    }
}
