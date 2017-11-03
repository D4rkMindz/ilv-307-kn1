<?php


namespace App\Service\Weather;


use DateTime;

class TemperatureService extends ImageGenerator
{
    protected $data;
    private $images = [];

    public function getImages()
    {
        $this->loadData()
            ->generate();
        return $this->images;
    }

    protected function generate()
    {
        $dir = __DIR__ . '/../../../public/images/temperature/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $date = date('Y-m-d_H');
        $now = DateTime::createFromFormat('Y-m-d_H', $date);
        if(!empty($dirs)) {
            $old = DateTime::createFromFormat('Y-m-d_H', $dirs[0]);
        } else {
            $old = false;
        }
        if ($now > $old) {
            if (!empty($dirs)){
                rmdir($dir . $dirs[0]);
            }
            for ($i = 0; $i < 7; $i++) {
                $date = $i;
                $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base.png');
                imagesavealpha($this->image, true);
                foreach ($this->data as $key => $record) {
                    $date = $record['list'][$i]['dt'];
                    $city = $record['city']['name'];
                    $max = $record['list'][$i]['temp']['max'];
                    $min = $record['list'][$i]['temp']['min'];
                    $this->setTemperature($this->cities[$city]['x'], $this->cities[$city]['y'],
                        $this->cities[$city]['name'], $min, $max);
                }
                imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                    __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
                $this->generateImage($date);
            }
        }
        $this->images = $this->read();
    }

    protected function setTemperature($x, $y, $name, $min, $max)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/roboto.ttf';
        // TODO Test this method.
        $red = ImageColorAllocate($this->image, 186, 0, 0);
        $orange = ImageColorAllocate($this->image, 188, 97, 0);
        $blue = ImageColorAllocate($this->image, 188, 97, 0);

        $minColor = $orange;
        $maxColor = $orange;
        if ($min < 10) {
            $minColor = $blue;
        }
        if ($min > 30) {
            $minColor = $red;
        }

        if ($max < 10) {
            $maxColor = $blue;
        }
        if ($max > 30) {
            $maxColor = $red;
        }

        imagettftext($this->image, 12, 0, $x - 6, $y, $minColor, $fontFile, 'Min: ' . round($min) . '°');
        imagettftext($this->image, 12, 0, $x + 6, $y, $maxColor, $fontFile, 'Max: ' . round($max) . '°');
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 186, 0, 0), $fontFile,
            $name . '%');
        return $this;
    }
}