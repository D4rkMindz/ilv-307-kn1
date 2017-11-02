<?php


namespace App\Service\Weather;


abstract class ImageGenerator
{
    protected $data;
    protected $cities;
    protected $image;

    protected abstract function generate();

    protected function setCity($x, $y, $name, $img)
    {
        $fontFile = __DIR__ . '/../../../resources/fonts/roboto.ttf';
        $im2 = imagecreatefrompng($img);

        imagecopy($this->image, $im2, $x, $y, 0, 0, imagesx($im2), imagesy($im2));
        imagettftext($this->image, 12, 0, $x + imagesx($im2), $y + (imagesy($im2) / 2), 0, $fontFile, $name);
        return $this;
    }

    protected function generateImage($date)
    {
        $file = __DIR__ . '/../../../public/images/weather/' . $date . '.png';
        imagepng($this->image, $file);
        return 'images/weather/' . $date . '.png';
    }
}
