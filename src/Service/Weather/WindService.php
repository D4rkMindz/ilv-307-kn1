<?php

namespace App\Service\Weather;

/**
 * Class WindService
 */
class WindService extends ImageGenerator
{
    protected $outputdir = 'wind';
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
                $deg = $record['list'][$i]['deg'];
                $speed = $record['list'][$i]['speed'];
                $this->setWind($this->cities[$city]['x'], $this->cities[$city]['y'], $this->cities[$city]['name'],
                    $deg, $speed);
            }
            imagettftext($this->image, 25, 0, 50, 50, ImageColorAllocate($this->image, 186, 0, 0),
                __DIR__ . '/../../../resources/fonts/falling-sky.ttf', date('d-m-Y H:i', $date));
            $this->generateImage($date);
        }
    }

    /**
     * Set wind.
     *
     * @param int $x X position on image
     * @param int $y Y position on image
     * @param string $name name of the city
     * @param float $deg wind direction
     * @param float $speed wind speed
     * @return WindService $this
     */
    protected function setWind($x, $y, $name, $deg, $speed)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/falling-sky.ttf';
        $arrow = imagecreatefrompng(__DIR__ . '/../../../files/weather/arrow.png');
        $angle = ($deg - 360) * -1;
        imagesavealpha($arrow, true);
        $transparency = imagecolorallocatealpha($arrow, 0, 0, 0, 127);
        $arrow = imagerotate($arrow, $angle, $transparency);

        imagecopy($this->image, $arrow, $x - (imagesx($arrow)) - 10, $y - (imagesy($arrow) / 2), 0, 0, imagesx($arrow),
            imagesy($arrow));
        imagettftext($this->image, 12, 0, $x, $y, ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        imagettftext($this->image, 12, 0, $x, $y + 20, ImageColorAllocate($this->image, 186, 0, 0), $fontFile,
            round($speed * 3.6) . ' km/h');
        return $this;
    }
}