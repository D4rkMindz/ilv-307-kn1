<?php


namespace App\Service\Weather;

class WindService extends ImageGenerator
{
    protected $outputdir = 'wind';
    protected $data;
    protected $images = [];

    public function getImages()
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
                    $deg = $record['list'][$i]['deg'];
                    $speed = $record['list'][$i]['speed'];
                    $this->setWind($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'],
                        $deg, $speed);
                }
                imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                    __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
                $this->generateImage($date);
            }
    }

    protected function setWind($x, $y, $name, $deg, $speed)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/roboto.ttf';
        $arrowFontFile = __DIR__ . '/../../../resources/fonts/arrows.ttf';
        imagettftext($this->image, $speed * 2, $deg, $x - $speed, $y - $speed, 0, $arrowFontFile, 'c');
        imagettftext($this->image, 12, 0, $x, $y, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 186, 0, 0), $fontFile,
            round($speed * 3.6) . ' km/h');
        return $this;
    }
}