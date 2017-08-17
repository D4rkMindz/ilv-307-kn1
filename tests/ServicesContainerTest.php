<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class ServicesContainerTest extends TestCase
{
    /**
     * DbBlockedUsersTest Container Instance.
     *
     * @covers ::container
     */
    public function testContainerInstance()
    {
        $actual = container();
        $this->assertInstanceOf(ParameterBag::class, $actual);
    }
}
