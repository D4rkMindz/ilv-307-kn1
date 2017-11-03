<?php


namespace App\Service\Weather;


class OpenWeatherMapApiRequestService
{
    /**
     * Get data from api.openweathermap.org
     *
     * @param string $url
     * @return mixed
     */
    public static function getCities($forceReload)
    {
        $cities = config()->get('weather.cities');
        $jsonFile = __DIR__ . '/../../../files/' . date('Y-m-d_H') . '.json';
        if (is_file($jsonFile) && !$forceReload) {
            $data = json_decode(file_get_contents($jsonFile), true);
            return $data;
        }
        $data = [];

        foreach ($cities as $city) {
            $url = 'forecast/daily?q=' . $city['name'] . '&units=metric';
            $data[] = self::curl($url);
        }

        file_put_contents($jsonFile, json_encode($data));
        return $data;
    }

    private static function curl($url)
    {
        $ch = curl_init();
        $config = config();
        $url = $config->get('weather.url.base') . $url . '&appid=' . $config->get('weather.key');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

    public static function get($url)
    {
        return self::curl($url);
    }
}
