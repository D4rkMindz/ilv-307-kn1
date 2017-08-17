<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Translation\Translator;

class ServicesTranslatorTest extends TestCase
{
    /**
     * ServicesContainerTest Translator Instance.
     *
     * @covers ::translator
     */
    public function testTranslatorInstance()
    {
        $storage = new MockArraySessionStorage();
        $session = new Session($storage);
        $container = container();
        $container->set('session', $session);
        $container->remove('translator');

        session()->set('lang', 'en_US');
        $actual = translator();
        $this->assertInstanceOf(Translator::class, $actual);
    }

    /**
     * ServicesContainerTest Translator without setting default language into session.
     *
     * @covers ::translator
     */
    public function testTranslatorWithoutLanguage()
    {
        $storage = new MockArraySessionStorage();
        $session = new Session($storage);

        $container = container();
        $container->set('session', $session);
        $container->remove('translator');

        $actual = translator();
        $lang = session()->get('lang');

        $this->assertInstanceOf(Translator::class, $actual);
        $this->assertSame("en_US", $lang);
    }
}
