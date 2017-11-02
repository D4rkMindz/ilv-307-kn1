<?php


namespace App\Service\Weather;


class WeatherService extends ImageGenerator
{
    protected $data;
    protected $cities;
    private $images = [];

    public function getImages(): array
    {
        $this->cities = config()->get('weather.cities');
        $this->loadData()
            ->generate();
        return $this->images;
    }

    protected function generate()
    {
        for ($i = 0; $i < 1; $i++) {
            $date = $i;
            $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base1.png');
            imagesavealpha($this->image, true);
            foreach ($this->data as $record) {
                $date = $record['list'][$i]['dt'];
                $city = $record['city']['name'];
                $icon = __DIR__ . '/../../../files/weather/icons/' . $record['list'][$i]['weather'][0]['icon'] . '.png';
                $this->setCity($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'], $icon);
            }
            $this->images[$date] = $this->generateImage($date);
        }
    }

    private function loadData()
    {
        foreach ($this->cities as $city) {
            $this->data[] = $this->getData($city['name']);
        }
        return $this;
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
