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
}
