<?php


namespace App\Service\Weather;


use DateTime;

abstract class ImageGenerator
{
    protected $data;
    protected $cities;
    protected $image;
    protected $outputdir;


    protected abstract function generate();

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
                foreach ($dirs as $d){
                    rrmdir($dir . $d);
                }
            }
            $this->loadData()
                ->generate();
        }
        $this->images = $this->read();
        return;
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


    protected function loadData()
    {
        $this->cities = config()->get('weather.cities');
        $jsonFile = __DIR__ . '/../../../files/' . date('Y-m-d_H') . '.json';
        $data = json_decode(file_get_contents($jsonFile), true);
        if (!empty($data)) {
            $this->data = $data;
            return $this;
        }
        foreach ($this->cities as $city) {
            $this->data[] = $this->getData($city['name']);
        }
        $json = json_encode($this->data);
        file_put_contents($jsonFile, $json);
        return $this;
    }

    private function getData($location)
    {
        $config = config();
        $url = $config->get('weather.url.base') . 'forecast/daily?q=' . $location . '&units=metric&appid=' . $config->get('weather.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

}