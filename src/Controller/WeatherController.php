<?php


namespace App\Controller;


use App\Service\ShoppingCart\ShoppingCartService;
use App\Service\Weather\HumidityService;
use App\Service\Weather\TemperatureService;
use App\Service\Weather\WeatherService;
use App\Service\Weather\WindService;

class WeatherController extends AppController
{
    public function index()
    {
        $weatherService = new WeatherService();
        $weatherImages = $weatherService->getImages();

//        $windService = new WindService();
//        $windImages = $windService->getImages();
//
//        $humidityService = new HumidityService();
//        $humidityImages = $humidityService->getImages();
//
//        $temperatureService = new TemperatureService();
//        $temperatureImages = $temperatureService->getImages();

        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'weather_images'=> $weatherImages,
//            'wind_images' => $windImages,
//            'humidity_images'=> $humidityImages,
//            'temperature_images'=> $temperatureImages,
            'count' => $count,
            'title' => 'Müller\'s Hofladen Wetter',
            'abbr' => 'Wetter',
            'news' => false,
        ];
        return $this->render('view::Weather/weather.html.php', $viewData);
    }
}
