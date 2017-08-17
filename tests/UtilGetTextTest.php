<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class UtilGetTextTest extends TestCase
{
    /**
     * Tests __ functions.
     *
     * @covers ::__
     * @covers ::translator
     */
    public function test__German()
    {
        $storage = new MockArraySessionStorage();
        $session = new Session($storage);
        container()->set('session', $session);
        session()->set('lang', 'de_DE');
        container()->set('translator', null);
        $translated = __("required");
        $this->assertSame("benötigt", $translated);
        container()->set('translator', null);
    }
    /**
     * Tests __ functions.
     *
     * @covers ::__
     * @covers ::translator
     */
    public function test__English()
    {
        $storage = new MockArraySessionStorage();
        $session = new Session($storage);
        container()->set('session', $session);
        session()->set('lang', 'en_US');
        container()->set('translator', null);
        $translated = __("required");
        $this->assertSame("required", $translated);
        container()->set('translator', null);
    }
}
