<?php

namespace App\Controller;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AppController
 */
class AppController
{
    protected $request;

    protected $response;

    protected $session;

    /**
     * AppController constructor.
     *
     * @param Request $request
     * @param Response $response
     * @param Session $session
     */
    public function __construct(Request $request, Response $response, Session $session)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
    }

    /**
     * Call Action.
     *
     * @param string $method
     * @param Request $request
     * @param Response $response
     *
     * @return Response|JsonResponse|RedirectResponse
     */
    public function callAction(string $method, Request $request, Response $response)
    {
        $newResponse = $this->beforeAction($request);
        if ($newResponse instanceof Response || $newResponse instanceof JsonResponse) {
            return $newResponse;
        }

        $result = call_user_func_array([$this, $method], [$request, $response]);

        return $result;
    }

    /**
     * Before Action.
     *
     * @param Request $request
     *
     * @return null|RedirectResponse
     */
    protected function beforeAction(Request $request = null/*, Response $response = null*/)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access-control-allow-origin,content-type,authorization");
        $auth = $request->attributes->get("_auth");

        if ($auth !== false && !$this->validateSession()) {
            return $this->redirect("/");
        }

        return null;
    }

    /**
     * Handling Session.
     *
     * @return bool if valid
     */
    protected function validateSession()
    {
        $status = $this->session->get("user_id");
        if (empty($status)) {
            return false;
        }

        return true;
    }

    /**
     * Render file.
     *
     * @param string $file
     * @param array $viewData | null
     *
     * @return Response $response
     */
    protected function render($file, array $viewData = [])
    {
        $templates = view();
        $viewData = $this->getData($viewData);
        $templates->addData($viewData);
        $content = $templates->render($file, $viewData);
        $this->response->setContent($content);

        return $this->response;
    }

    /**
     * Get user Data (role).
     *
     * @param array $data
     *
     * @return array $result
     */
    protected function getData($data = [])
    {
        $default = [
            'admin' => $this->hasRole("admin"),
            'baseurl' => baseurl("/"),
        ];
        $result = array_merge($default, $data);

        return $result;
    }

    /**
     * hasRole function.
     *
     * @param string|array $role
     *
     * @return bool true if role in session
     */
    public function hasRole($role)
    {
        $right = $this->session->get("user_role");
        $result = in_array($right, (array)$role);

        return $result;
    }

    /**
     * Redirect.
     *
     * @param string $url
     * @param bool $base
     *
     * @return RedirectResponse
     */
    protected function redirect($url, $base = true)
    {
        if ($base) {
            $url = baseurl($url);
        }

        return new RedirectResponse($url);
    }

    /**
     * Get JSON request as array.
     *
     * @param Request $request
     *
     * @return array
     * @throws Exception
     */
    protected function getJsonRequest(Request $request)
    {
        $requestContent = $request->getContent();
        $result = json_decode($requestContent, true);
        if (empty($result) || !is_array($result)) {
            throw new Exception('Invalid Json request');
        }

        return $result;
    }

    /**
     * Create JSON-RPC Object
     *
     * @param array|string $result
     * @param mixed $status
     *
     * @return JsonResponse
     */
    protected function json($result, $status = 200)
    {
        if (array_key_exists('status', $result)) {
            $status = $result['status'] == 'error' ? 422 : 200;
        }

        return new JsonResponse($result, $status);
    }
}
