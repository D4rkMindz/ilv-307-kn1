<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiController
 */
class ApiController extends AppController
{
    /**
     * Before action.
     *
     * @param Request $request
     * @return null|Response
     */
    protected function beforeAction(Request $request = null/*, Response $response = null*/)
    {
        //TODO: Remove for AUTH
        return null;
        $auth = $request->attributes->get('_auth');
        if ($auth) {
            $server = oauth2_server();
            $req = \OAuth2\HttpFoundationBridge\Request::createFromGlobals();
            if (!$server->verifyResourceRequest($req)) {
                $response = $server->getResponse();

                $content = [
                    'status_code' => $response->getStatusCode(),
                    'message' => $response->getStatusText(),
                ];

                return new Response(json_encode($content), 401,
                    ['WWW-Authenticate' => 'Basic realm="Please enter your login data"']);
            }
        }

        return null;
    }

    /**
     * Return Error response.
     *
     * @param string $message - translated error message
     * @param string $errorType - add ERROR_TYPE here
     * @param int $statusCode - HTTP STATUS CODE
     * @return JsonResponse
     */
    public function returnError(
        string $message,
        string $errorType = 'ERROR_INAPPROPRIATE_VALUE',
        int $statusCode = 422
    ): JsonResponse {
        $response = [
            'status' => 'ERROR_' . $statusCode,
            'message' => $errorType,
            'error' => $message,
        ];

        return $this->json($response, $statusCode);
    }
}
