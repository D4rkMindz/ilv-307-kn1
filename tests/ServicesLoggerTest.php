<?php

namespace App\Test;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class ServicesLoggerTest extends TestCase
{
    /**
     * ServicesContainerTest Logger.
     *
     * @covers ::logger
     */
    public function testLogger()
    {
        $logger = logger("test");
        $this->assertInstanceOf(Logger::class, $logger);
    }
}
