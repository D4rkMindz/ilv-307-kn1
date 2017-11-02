<?php


namespace App\Service\Weather;


class ImageGenerator
{
    private $image;
    private $date;
    private $data;

    public function __construct(string $date, array $data)
    {
        $this->image = imagecreatefrompng(__DIR__ . '/../../../files/weather/base.png');
        $this->date = $date;
        $this->data = $data;
    }

    public function generate()
    {
        $img = __DIR__ . '/../../../files/weather/icons' . $this->data['weather'][0]['icon'];
        return $this->setCity(0, 0, $img)
            ->generateImage();
    }

    private function setCity($x, $y, $img)
    {
        imagealphablending($img, true);
        imagesavealpha($img, true);
        imagecopy($img, $this->image, $x, $y, 0, 0, 100, 100);
        return $this;
    }

    private function generateImage()
    {
        $file = __DIR__ . '/../../../files/weather/' . $this->date . '.png';
        imagepng($this->image, $file);
        $png = file_get_contents($file);
        return 'data:image/png;base64,' . base64_encode($png);
    }
}
