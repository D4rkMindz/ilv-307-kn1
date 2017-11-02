<?php


namespace App\Controller;


use App\Service\ShoppingCart\ShoppingCartService;
use App\Service\Weather\WeatherService;

class WeatherController extends AppController
{
    public function index()
    {
        $weatherService = new WeatherService();
        $weatherImages = $weatherService->getImages();

        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'weather_images'=> $weatherImages,
            'count' => $count,
            'title' => 'Müller\'s Hofladen Wetter',
            'abbr' => 'Wetter',
            'news' => false,
        ];
        return $this->render('view::Weather/weather.html.php', $viewData);
    }
}
