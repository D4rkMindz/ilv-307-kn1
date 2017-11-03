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
    public static function getCities()
    {
        $cities = config()->get('weather.cities');
        $jsonFile = __DIR__ . '/../../../files/' . date('Y-m-d_H') . '.json';
        if (is_file($jsonFile)) {
            $data = json_decode(file_get_contents($jsonFile), true);
            return $data;
        }
        $data = [];

        foreach ($cities as $city) {
            $url = 'forecast/daily?q=' . $city['name'] . '&units=metric';
            $data[] = self::curl($url);
        }

        $json = json_encode($data);
        file_put_contents($jsonFile, $json);
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
        return $data;
    }

    public static function get($url, $tag)
    {
        $jsonFile = __DIR__ . '/../../../files/citydata/' . date('Y-m-d_H') . $tag . '.json';
        if (is_file($jsonFile)) {
            $data = json_decode(file_get_contents($jsonFile), true);
            return $data;
        }
        $json = self::curl($url);

        $data = json_decode($json, true);
        file_put_contents($jsonFile, $json);
        return $data;
    }
}
