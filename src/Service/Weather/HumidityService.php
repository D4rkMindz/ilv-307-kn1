<?php


namespace App\Service\Weather;


use DateTime;

class HumidityService extends ImageGenerator
{
    protected $outputdir = 'humidity';
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
                $humidity = $record['list'][$i]['humidity'];
                $this->setHumidity($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'],
                    $humidity);
            }
            imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
            $this->generateImage($date);
        }
    }

    protected function setHumidity($x, $y, $name, $humidity)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/roboto.ttf';
        // TODO Test this method.
        imagettftext($this->image, 12, 0, $x, $y, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $humidity . '%');
        return $this;
    }
}
