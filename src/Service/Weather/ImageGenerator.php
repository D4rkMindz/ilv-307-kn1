<?php


namespace App\Service\Weather;


use DateTime;

abstract class ImageGenerator
{
    protected $data;
    protected $cities;
    protected $image;
    protected $outputdir;

    protected function check($forceReload = false)
    {
        $dir = __DIR__ . '/../../../public/images/' . $this->outputdir . '/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $date = date('Y-m-d_H');
        $now = DateTime::createFromFormat('Y-m-d_H', $date);
        if (!empty($dirs)) {
            $old = DateTime::createFromFormat('Y-m-d_H', $dirs[0]);
        } else {
            $old = false;
        }
        if ($now > $old || $forceReload) {
            if (!empty($dirs)) {
                foreach ($dirs as $d) {
                    rrmdir($dir . $d);
                }
            }
            $this->loadData($forceReload)
                ->generate();
        }
        $this->images = $this->read();
        return;
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

    protected abstract function generate();

    protected function loadData($forceReload)
    {
        $this->data = OpenWeatherMapApiRequestService::getCities($forceReload);
        return $this;
    }


    protected function read()
    {
        $dir = __DIR__ . '/../../../public/images/weather/';
        $dirs = $this->scandir($dir);
        rsort($dirs);
        $images = array_diff(scandir($dir . '/' . $dirs[0]), ['.', '..']);
        foreach ($images as $key => $image) {
            $images[$key] = 'images/' . $this->outputdir . '/' . $dirs[0] . '/' . $image;
        }
        $images = array_values($images);
        return $images;
    }

    protected function generateImage($date)
    {
        $dir = date('Y-m-d_H');
        $d = __DIR__ . '/../../../public/images/' . $this->outputdir . '/' . $dir;
        if (!is_dir($d)) {
            mkdir($d);
        }
        $file = $d . '/' . $date . '.png';
        imagepng($this->image, $file);
    }

}