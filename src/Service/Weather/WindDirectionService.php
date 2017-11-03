<?php


namespace App\Service\Weather;

/**
 * Class WindDirectionService
 */
class WindDirectionService
{
    private $image;

    /**
     * Create image.
     *
     * @param int $deg
     * @return string
     */
    public function create($deg)
    {
        $public = 'images/wind-dir/' . $deg . '.png';
        $file = __DIR__ . '/../../../public/' . $public;
        if (!is_file($file)) {
            $rgb = array(255, 255, 255);
            $rgb = array(255 - $rgb[0], 255 - $rgb[1], 255 - $rgb[2]);

            $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/wind-dir.png');
            imagefilter($this->image, IMG_FILTER_NEGATE);
            imagefilter($this->image, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]);
            imagefilter($this->image, IMG_FILTER_NEGATE);

            imagealphablending($this->image, false);

            imagesavealpha($this->image, true);
            $arrow = imagecreatefrompng(__DIR__ . '/../../../files/weather/arrow.png');
            $angle = ($deg - 360) * -1;
            imagesavealpha($arrow, true);
            $transparency = imagecolorallocatealpha($arrow, 0, 0, 0, 127);
            $arrow = imagerotate($arrow, $angle, $transparency);

            imagecopy($this->image, $arrow, 150 - (imagesx($arrow)), 184 - (imagesy($arrow) / 2), 0, 0, imagesx($arrow),
                imagesy($arrow));
            imagepng($this->image, $file);
        }
        return $public;
    }
}
