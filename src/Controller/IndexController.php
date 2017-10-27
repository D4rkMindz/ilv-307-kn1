<?php

namespace App\Controller;

use App\Service\ShoppingCart\ShoppingCartService;
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
        $success =  $this->session->get('success') ? true : false;
        if ($success){
            $this->session->set('success', false);
        }

        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'count'=> $count,
            'title' => 'Herzlich Willkommen in Müller\'s Hofladen',
            'abbr' => 'Home',
            'news' => true,
            'success' => $success,
        ];
        return $this->render('view::Index/index.html.php', $viewData);
    }

    public function openingHours()
    {
        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'count'=> $count,
            'title' => 'Öffnungszeiten des Hofladens',
            'abbr' => 'Öffnungszeiten',
            'news' => true,
        ];
        return $this->render('view::Index/opening-hours.html.php', $viewData);
    }

    public function contact()
    {
        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'count'=> $count,
            'title' => 'Unsere Kontaktdaten',
            'abbr' => 'Kontakt',
            'news' => true,
        ];
        return $this->render('view::Index/contact.html.php', $viewData);
    }
}
