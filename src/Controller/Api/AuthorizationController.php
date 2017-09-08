<?php

namespace App\Controller\Api;

use OAuth2\HttpFoundationBridge\Request;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends ApiController
{
    /**
     * Get Auth.
     */
    public function getAuth()
    {
        $server = oauth2_server();
        $req = Request::createFromGlobals();
        $server->handleTokenRequest($req)->send();
    }
}
