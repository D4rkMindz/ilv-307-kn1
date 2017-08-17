<?php

namespace App\Test;

use App\Controller\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TestController
 *
 * for Testing
 */
class TestController extends AppController
{
    /**
     * Before Action.
     *
     * Is called before every action.
     *
     * @param Request $request
     * @return string ""
     */
    public function beforeAction(Request $request = null/*, Response $response = null*/)
    {
        return "";
    }

    /**
     * Index page.
     *
     * Index action.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json(['response' => 'Hello World!'], 200);
    }
}
