<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;

class ServicesSessionTest extends TestCase
{
    /**
     * ServicesContainerTest Session.
     *
     * @covers ::session
     */
    public function testSession()
    {
        $container = container();
        $container->remove('session');
        $session = session();

        $actual = container()->get('session');
        $this->assertSame($session, $actual);
        $this->assertInstanceOf(Session::class, $session);
    }
}
