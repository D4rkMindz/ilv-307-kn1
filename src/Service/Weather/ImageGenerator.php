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
        imagettftext($this->image, 12, 0, $x + imagesx($im2), $y + (imagesy($im2) / 2),
            ImageColorAllocate($this->image, 186, 0, 0), $fontFile, $name);
        return $this;
    }

    protected function generateImage($date)
    {
        $dir = date('Y-m-d_H');
        $d = __DIR__ . '/../../../public/images/weather/' . $dir;
        if (!is_dir($d)) {
            mkdir($d);
        }
        $file = $d . '/' . $date . '.png';
        imagepng($this->image, $file);
    }

    protected function read()
    {
        $dir = __DIR__ . '/../../../public/images/weather/';
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $images = array_diff(scandir($dir . '/' . $dirs[0]), ['.', '..']);
        foreach ($images as $key => $image) {
            $images[$key] = 'images/weather/' . $dirs[0] . '/' . $image;
        }
        return $images;
    }

    protected function scandir($dir)
    {
        $dirs = array_diff(scandir($dir), ['.', '..']);;
        $return = [];
        foreach ($dirs as $d) {
            if (is_dir($dir . $d)) {
                $return[] = $d;
            }
        }
        return $return;
    }
}
