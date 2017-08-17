<?php

namespace App\Controller;

class ErrorController extends AppController
{
    public function index()
    {
        $errorcode = $this->request->get('errorcode');
        if ($errorcode >= 700){
            $errorcode = 405;
        }
        return $this->render('view::Error/error.html.php',['code' => $errorcode]);
    }

    public function error404()
    {
        return $this->render('view::Error/error.html.php',['code' => 404]);
    }

    public function error500()
    {
        return $this->render('view::Error/error.html.php',['code' => 500]);
    }
}
