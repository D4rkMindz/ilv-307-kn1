<?php


namespace App\Service\Weather;


use DateTime;

class HumidityService extends ImageGenerator
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
        $dir = __DIR__ . '/../../../public/images/humidity/';
        if (!is_dir($dir)){
            mkdir($dir);
        }
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $date = date('Y-m-d_H');
        $now = DateTime::createFromFormat('Y-m-d_H', $date);
        $old = DateTime::createFromFormat('Y-m-d_H', $dirs[0]);
        if ($now > $old) {
            rmdir($dirs[0]);
            for ($i = 0; $i < 7; $i++) {
                $date = $i;
                $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base.png');
                imagesavealpha($this->image, true);
                foreach ($this->data as $key => $record) {
                    $date = $record['list'][$i]['dt'];
                    $city = $record['city']['name'];
                    $humidity = $record['list'][$i]['humidity'];
                    $this->setHumidity($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'], $humidity);
                }
                imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                    __DIR__ . '/../../../resources/fonts/roboto.ttf', date('d-m-Y H:i', $date));
                $this->generateImage($date);
            }
        }
        $this->images = $this->read();
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
