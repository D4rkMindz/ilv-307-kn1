<?php


namespace App\Service\Weather;

/**
 * Class WeatherService
 */
class WeatherService extends ImageGenerator
{
    protected $outputdir = 'weather';
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
                $icon = __DIR__ . '/../../../files/weather/icons/' . $record['list'][$i]['weather'][0]['icon'] . '.png';
                $this->setWeather($this->cities[$city]['x'], $this->cities[$city]['y'],
                    $this->cities[$city]['name'],
                    $icon);
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
     * @param string $img icon image directory
     * @return WeatherService $this
     */
    protected function setWeather($x, $y, $name, $img)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/falling-sky.ttf';
        $im2 = imagecreatefrompng($img);

        imagecopy($this->image, $im2, $x, $y, 0, 0, imagesx($im2), imagesy($im2));
        imagettftext($this->image, 12, 0, $x + imagesx($im2), $y + (imagesy($im2) / 2),
            ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        return $this;
    }
}
