<?php


namespace App\Service\ShoppingCart;


use Symfony\Component\HttpFoundation\Session\Session;

class CaptchaService
{
    private $image;
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function generate()
    {
        $image = $this->generateMainFrame()
            ->generateDots()
            ->generateLines()
            ->generateWord();
        return $image->generateImage();
    }

    private function generateMainFrame()
    {
        $this->image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($this->image, 255, 255, 255);
        imagefilledrectangle($this->image, 0, 0, 200, 50, $background_color);
        return $this;
    }

    private function generateLines()
    {
        $line_color = imagecolorallocate($this->image, 64, 64, 64);
        for ($i = 0; $i < 10; $i++) {
            imageline($this->image, 0, rand() % 50, 200, rand() % 50, $line_color);
        }
        return $this;
    }

    private function generateDots()
    {
        $pixel_color = imagecolorallocate($this->image, 0, 0, 255);
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($this->image, rand() % 200, rand() % 50, $pixel_color);
        }
        return $this;
    }

    private function generateWord()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $len = strlen($letters);
        $text_color = imagecolorallocate($this->image, 0, 0, 0);
        $word = '';
        for ($i = 0; $i < 6; $i++) {
            $letter = $letters[rand(0, $len - 1)];
            imagestring($this->image, 5, 5 + ($i * 30), 20, $letter, $text_color);
            $word .= $letter;
        }
        $this->session->set('captcha', $word);
        return $this;
    }

    private function generateImage()
    {
        $file = __DIR__ . '/../../../files/captchas/' . sha1(microtime(true)) . '.png';
        imagepng($this->image, $file);
        $png = file_get_contents($file);
        unlink($file);
        return 'data:image/png;base64,' . base64_encode($png);
    }
}
