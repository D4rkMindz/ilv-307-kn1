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
    public static function get(string $url)
    {
        $ch = curl_init();
        $config = config();
        $url = $config->get('weather.url.base') .  $url . '&appid=' . $config->get('weather.key');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }
}
