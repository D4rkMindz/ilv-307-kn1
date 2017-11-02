<?php


namespace App\Service\ShoppingCart;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CaptchaService
 */
class CaptchaService
{
    /**
     * @var resource $image png image.
     */
    private $image;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * CaptchaService constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Generate captcha.
     *
     * @return string base64 png image
     */
    public function generate(): string
    {
        $image = $this->generateMainFrame()
            ->generateDots()
//            ->generateLines()
            ->generateWord();
        return $image->generateImage();
    }

    /**
     * Generate main image frame.
     *
     * @return CaptchaService $this
     */
    private function generateMainFrame(): CaptchaService
    {
        $this->image = imagecreatetruecolor(200, 50);
        $backgroundColor = imagecolorallocate($this->image, 255, 255, 255);
        imagefilledrectangle($this->image, 0, 0, 200, 50, $backgroundColor);
        return $this;
    }

    /**
     * Generate randome lines,
     *
     * @return CaptchaService $this
     */
    private function generateLines(): CaptchaService
    {
        $lineColor = imagecolorallocate($this->image, 64, 64, 64);
        for ($i = 0; $i < 10; $i++) {
            imageline($this->image, 0, rand() % 50, 200, rand() % 50, $lineColor);
        }
        return $this;
    }

    /**
     * Generate random dots.
     *
     * @return CaptchaService $this
     */
    private function generateDots(): CaptchaService
    {
        $pixelColor = imagecolorallocate($this->image, 0, 0, 255);
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($this->image, rand() % 200, rand() % 50, $pixelColor);
        }
        return $this;
    }

    /**
     * Generate word and save it to session (captcha).
     *
     * @return CaptchaService $this
     */
    private function generateWord(): CaptchaService
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $fontFile = __DIR__ . '/../../../resources/fonts/courgette.ttf';
        $len = strlen($letters);
        $textColor = imagecolorallocate($this->image, 255, 0, 0);
        $word = '';
        for ($i = 0; $i < 6; $i++) {
            $letter = $letters[rand(0, $len - 1)];
//            imagestring($this->image, 5, 5 + ($i * 30), 20, $letter, $textColor);
            imagettftext($this->image, 20, rand(0, 45), 5 + ($i * 30), 40, $textColor, $fontFile, $letter);
            $word .= $letter;
        }
        $this->session->set('captcha', $word);
        return $this;
    }

    /**
     * Final method to generate image.
     *
     * @return string base64 png image
     */
    private function generateImage(): string
    {
        $file = __DIR__ . '/../../../files/captchas/' . sha1(microtime(true)) . '.png';
        imagepng($this->image, $file);
        $png = file_get_contents($file);
        unlink($file);
        return 'data:image/png;base64,' . base64_encode($png);
    }
}
