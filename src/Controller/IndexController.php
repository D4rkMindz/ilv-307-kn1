<?php

namespace App\Controller;

class IndexController extends AppController
{
    public function index()
    {
        return $this->render('view::Index/index.html.php');
    }
}
