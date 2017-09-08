<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ErrorController
 */
class ErrorController extends AppController
{
    /**
     * Load default Error Page
     *
     * @return Response
     */
    public function index()
    {
        $errorcode = $this->request->attributes->get('errorcode');
        if ($errorcode >= 700){
            $errorcode = 405;
        }
        return $this->render('view::Error/error.html.php',['code' => $errorcode]);
    }

    /**
     * Load ERROR_404 Page
     *
     * @return Response
     */
    public function error404()
    {
        return $this->render('view::Error/error.html.php',['code' => 404]);
    }

    /**
     * Load ERROR_500 Page
     *
     * @return Response
     */
    public function error500()
    {
        return $this->render('view::Error/error.html.php',['code' => 500]);
    }
}
