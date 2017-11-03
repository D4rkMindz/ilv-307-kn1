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
        $forceReload = (bool)$this->request->query->get('_r');
        $forceReloadWeather = false;
        $forceReloadTemperature = false;
        $forceReloadHumidity = false;
        $forceReloadWind = false;
        $type = (int)$this->request->query->get('_t');
        switch ($type) {
            case 1:
                $forceReloadWeather = $forceReload;
                break;
            case 2:
                $forceReloadHumidity = $forceReload;
                break;
            case 3:
                $forceReloadTemperature = $forceReload;
                break;
            case 4:
                $forceReloadWind = $forceReload;
                break;
            default:
                if ($forceReload && empty($type)) {
                    $forceReloadWeather = $forceReload;
                    $forceReloadTemperature = $forceReload;
                    $forceReloadHumidity = $forceReload;
                    $forceReloadWind = $forceReload;
                }
                break;
        }

        $weatherService = new WeatherService();
        $weatherImages = $weatherService->getImages($forceReloadWeather);

        $windService = new WindService();
        $windImages = $windService->getImages($forceReloadWind);

        $humidityService = new HumidityService();
        $humidityImages = $humidityService->getImages($forceReloadHumidity);

        $temperatureService = new TemperatureService();
        $temperatureImages = $temperatureService->getImages($forceReloadTemperature);

        $shoppingCartService = new ShoppingCartService($this->session);
        $count = $shoppingCartService->getCount();
        $viewData = [
            'weather_images' => $weatherImages,
            'wind_images' => $windImages,
            'humidity_images' => $humidityImages,
            'temperature_images' => $temperatureImages,
            'count' => $count,
            'title' => 'Müller\'s Hofladen Wetter',
            'abbr' => 'Wetter',
            'news' => false,
        ];
        return $this->render('view::Weather/weather.html.php', $viewData);
    }
}
