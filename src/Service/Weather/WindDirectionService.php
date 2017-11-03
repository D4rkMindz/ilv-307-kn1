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
            $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/wind-dir.png');
            $arrow = imagecreatefrompng(__DIR__ . '/../../../files/weather/arrow.png');
            $angle = ($deg - 360) * -1;
            imagesavealpha($arrow, true);
            $transparency = imagecolorallocatealpha($arrow, 0, 0, 0, 127);
            $arrow = imagerotate($arrow, $angle, $transparency);
            $this->image = imagerotate($this->image, 0, $transparency);

            imagecopy($this->image, $arrow, (imagesx($this->image) / 2) - (imagesx($arrow) / 2), (imagesy($this->image) / 2) - (imagesy($arrow) / 2) + 5, 0, 0, imagesx($arrow), imagesy($arrow));

            imagepng($this->image, $file);
        }
        return $public;
    }
}
