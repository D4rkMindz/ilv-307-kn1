<?php


namespace App\Service\Weather;

class WeatherService extends ImageGenerator
{
    protected $outputdir = 'weather';
    protected $data;
    protected $images = [];

    public function getImages(): array
    {
        $this->check();
        return $this->images;
    }

    protected function generate()
    {
        for ($i = 0; $i < 7; $i++) {
            $date = $i;
            $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base.png');
            imagesavealpha($this->image, true);
            foreach ($this->data as $key => $record) {
                $date = $record['list'][$i]['dt'];
                $city = $record['city']['name'];
                $icon = __DIR__ . '/../../../files/weather/icons/' . $record['list'][$i]['weather'][0]['icon'] . '.png';
                $this->setWeather($this->cities[$city]['x'], $this->cities[$city]['y'],
                    $this->cities[$city]['name'],
                    $icon);
            }
            imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
            $this->generateImage($date);
        }
    }

    protected function setWeather($x, $y, $name, $img)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/roboto.ttf';
        $im2 = imagecreatefrompng($img);

        imagecopy($this->image, $im2, $x, $y, 0, 0, imagesx($im2), imagesy($im2));
        imagettftext($this->image, 12, 0, $x + imagesx($im2), $y + (imagesy($im2) / 2),
            ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        return $this;
    }
}
