<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ServicesRequestTest extends TestCase
{
    /**
     * ServicesContainerTest Request.
     *
     * @covers ::request
     */
    public function testRequest()
    {
        $request = request();
        $actual = container()->get('request');
        $this->assertSame($request, $actual);
        $this->assertInstanceOf(Request::class, $request);
    }

    /**
     * ServicesContainerTest Request without data in container.
     *
     * @covers ::request
     */
    public function testRequestEmpty()
    {
        $container = container();
        $container->remove('request');
        $request = request();
        $actual = $container->get('request');
        $this->assertSame($request, $actual);
        $this->assertInstanceOf(Request::class, $request);
    }
}
