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
        $dirs = $this->scandir(__DIR__ . '/../../../public/images/weather/');
        rsort($dirs);
        $date = date('Y-m-d_H');
        if (in_array($date, $dirs) && strtotime($date) > strtotime($dirs[0])){
            for ($i = 0; $i < 7; $i++) {
                $date = $i;
                $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base.png');
                imagesavealpha($this->image, true);
                foreach ($this->data as $key => $record) {
                    $date = $record['list'][$i]['dt'];
                    $city = $record['city']['name'];
                    $icon = __DIR__ . '/../../../files/weather/icons/' . $record['list'][$i]['weather'][0]['icon'] . '.png';
                    $this->setCity($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'],
                        $icon);
                }
                imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                    __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
                $this->generateImage($date);
            }
        }
        $this->images = $this->read();
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
        $url = $config->get('weather.url.base') . 'forecast/daily?q=' . $location . '&appid=' . $config->get('weather.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }
}
