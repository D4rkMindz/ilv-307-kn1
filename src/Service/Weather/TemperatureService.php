<?php


namespace App\Service\Weather;


use DateTime;

class TemperatureService extends ImageGenerator
{
    protected $outputdir = 'temperature';
    protected $data;
    protected $images = [];

    /**
     * Get Images
     *
     * @param bool $forceReload
     * @return array with image urls
     */
    public function getImages($forceReload = false): array
    {
        $this->load($forceReload);
        return $this->images;
    }

    /**
     * Generate image function
     */
    protected function generate()
    {
        $this->cities = config()->get('weather.cities');
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
                __DIR__ . '/../../../resources/fonts/falling-sky.ttf', date('d-m-Y H:i', $date));
            $this->generateImage($date);
        }
    }

    /**
     * Set temperature.
     *
     * @param int $x X position on image
     * @param int $y Y position on image
     * @param string $name name of the city
     * @param string $min minimum temperature
     * @param string $max maximum temperature
     * @return TemperatureService $this
     */
    protected function setTemperature($x, $y, $name, $min, $max)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/falling-sky.ttf';
        $red = ImageColorAllocate($this->image, 186, 0, 0);
        $orange = ImageColorAllocate($this->image, 188, 97, 0);
        $blue = ImageColorAllocate($this->image, 0, 86, 226);

        $minColor = $orange;
        $maxColor = $orange;
        if ($min <= 10) {
            $minColor = $blue;
        }
        if ($min >= 30) {
            $minColor = $red;
        }

        if ($max <= 10) {
            $maxColor = $blue;
        }
        if ($max >= 30) {
            $maxColor = $red;
        }

        imagettftext($this->image, 12, 0, $x, $y - 20, $minColor, $fontFile, 'Min: ' . round($min) . '°');
        imagettftext($this->image, 12, 0, $x, $y, $maxColor, $fontFile, 'Max: ' . round($max) . '°');
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        return $this;
    }
}