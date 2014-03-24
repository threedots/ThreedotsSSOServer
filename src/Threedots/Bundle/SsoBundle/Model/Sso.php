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
        $ssoService = $this->get('sso_service');

        switch($request) {

            case 'info'     : $response = $ssoService->getUserInfoFromSession();  break;
            case 'login'    : $response = $ssoService->login();                   break;
            case 'attach'   : $response = $ssoService->attach();                  break;
            case 'logout'   : $response = $ssoService->logout();                  break;
            default         : $response = false;
        }

        return $response;
    }
}