<?php

namespace App\Service\Weather;

/**
 * Class HumidityService
 */
class HumidityService extends ImageGenerator
{
    protected $outputdir = 'humidity';
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
        $this->check($forceReload);
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
                $humidity = $record['list'][$i]['humidity'];
                $this->setHumidity($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'],
                    $humidity);
            }
            imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                __DIR__ . '/../../../resources/fonts/falling-sky.ttf', date('d-m-Y H:i', $date));
            $this->generateImage($date);
        }
    }

    /**
     * Set humidity
     *
     * @param int $x X position on image
     * @param int $y Y position on image
     * @param string $name name of the city
     * @param float $humidity humidity value
     * @return $this
     */
    protected function setHumidity($x, $y, $name, $humidity)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/falling-sky.ttf';
        imagettftext($this->image, 12, 0, $x, $y, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 0, 86, 226), $fontFile, $humidity . '%');
        return $this;
    }
}
