<?php


namespace App\Service\Weather;


class WeatherService
{
    private $data;

    public function getImages(): array
    {
        $this->loadData();
        $imageGenerator = new ImageGenerator($this->data[0]['list'][0]['dt'], $this->data[0]['list'][0]);
        return [$imageGenerator->generate()];
    }

    private function loadData()
    {
        $cities = config()->get('weather.cities');
        foreach ($cities as $city) {
            $this->data[] = $this->getData($city);
        }
    }

    private function getData($location)
    {
        $config = config();
        $url = $config->get('weather.url.base') . 'forecast?q=' . $location . '&cnt=8&appid=' . $config->get('weather.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }
}
