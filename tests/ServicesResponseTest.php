<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ServicesResponseTest extends TestCase
{
    /**
     * ServicesContainerTest Response.
     *
     * @covers ::response
     */
    public function testResponse()
    {
        $response = response();
        $actual = container()->get('response');
        $this->assertSame($response, $actual);
        $this->assertInstanceOf(Response::class, $response);
    }
}
