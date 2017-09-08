<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
 */
class IndexController extends AppController
{
    /**
     * Index action.
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('view::Index/index.html.php');
    }
}
