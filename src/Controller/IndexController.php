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
        $viewData = [
            'title' => 'Herzlich Willkommen in Müller\'s Hofladen',
            'abbr'=> 'Home',
            'news' => true,
        ];
        return $this->render('view::Index/index.html.php', $viewData);
    }

    public function openingHours()
    {
        $viewData = [
            'title' => 'Öffnungszeiten des Hofladens',
            'abbr'=> 'Öffnungszeiten',
            'news' => true,
        ];
        return $this->render('view::Index/opening-hours.html.php', $viewData);
    }
}
