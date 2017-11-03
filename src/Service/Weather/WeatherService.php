<?php


namespace App\Service\Weather;


use DateTime;

class WeatherService extends ImageGenerator
{
    protected $data;
    private $images = [];

    public function getImages(): array
    {
        $this->loadData()
            ->generate();
        return $this->images;
    }

    protected function generate()
    {
        $dir = __DIR__ . '/../../../public/images/weather/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $date = date('Y-m-d_H');
        $now = DateTime::createFromFormat('Y-m-d_H', $date);
        if (!empty($dirs)) {
            $old = DateTime::createFromFormat('Y-m-d_H', $dirs[0]);
        } else {
            $old = false;
        }
        if ($now > $old) {
            if (!empty($dirs)) {
                rmdir($dir . $dirs[0]);
            }
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
        $this->images = $this->read();
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
