<?php

namespace App\Controller;

use App\Service\ShoppingCart\ShoppingCartService;
use App\Service\Weather\CityService;
use App\Service\Weather\CityValidation;
use App\Service\Weather\HumidityService;
use App\Service\Weather\OpenWeatherMapApiRequestService;
use App\Service\Weather\TemperatureService;
use App\Service\Weather\WeatherService;
use App\Service\Weather\WindDirectionService;
use App\Service\Weather\WindService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WeatherController
 */
class WeatherController extends AppController
{
    /**
     * Index.
     *
     * @return Response
     */
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
            'news' => true,
            'city_data' => [],
        ];
        return $this->render('view::Weather/weather.html.php', $viewData);
    }

    /**
     * Get City by ID.
     *
     * @return JsonResponse
     */
    public function getByCity()
    {
        $data = $this->getJsonRequest($this->request);
        $validationContext = CityValidation::validate($data);
        if (!$validationContext->success()){
            return $this->json($validationContext->toArray(), 422);
        }
        $url = 'weather?q=' . $data['city'] . '&units=metric';
        $data = OpenWeatherMapApiRequestService::get($url);
        if ($data['cod'] === 200){
            $windDirectionService = new WindDirectionService();
            $data = CityService::format($data);
            $data['wurl'] =$windDirectionService->create($data['wdir']);
            $status = 200;
        } else {
            $validationContext->setError('city', 'Stadt existiert nicht');
            $data = $validationContext->toArray();
            $status = 422;
        }
        return $this->json($data, $status);
    }
}
