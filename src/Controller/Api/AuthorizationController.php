<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use OAuth2\Request;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends AppController
{
    /**
     * Get Auth.
     */
    public function getAuth()
    {
        $server = oauth2_server();
        $req = Request::createFromGlobals();
        return $server->handleTokenRequest($req)->send();
    }
}
