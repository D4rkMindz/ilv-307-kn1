<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;

class ServicesRouteTest extends TestCase
{
    /**
     * ServicesContainerTest Route.
     *
     * @covers ::route
     */
    public function testRoute()
    {
        $actual = route("submit", "/test_path", "TestController");
        $this->assertInstanceOf(Route::class, $actual);
    }
}
