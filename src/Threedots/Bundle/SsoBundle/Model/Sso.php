<?php

/*
 * This file is part of the falgun phantom bundle.
 *
 * (c) Threedots.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Threedots\Bundle\SsoBundle\Model;

/**
 * Class Sso
 * @package Threedots\Bundle\SsoBundle\Model
 */
class Sso extends Base
{
    /**
     * @param $request
     * @return bool
     */
    public function processRequest($request)
    {
        $ssoServer = $this->get('sso_server');

        switch($request) {

            case 'info'     : $response = $ssoServer->getUserInformation();  break;
            case 'login'    : $response = $ssoServer->login();               break;
            case 'attach'   : $response = $ssoServer->attach();              break;
            case 'logout'   : $response = $ssoServer->logout();              break;
            default         : $response = false;
        }

        return $response;
    }
}