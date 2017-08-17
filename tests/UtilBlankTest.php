<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;

class UtilBlankTest extends TestCase
{
    /**
     * DbBlockedUsersTest blank regular.
     *
     * @covers ::blank
     */
    public function testBlankRegular()
    {
        $condition = blank("");
        $this->assertTrue($condition);
    }

    /**
     * DbBlockedUsersTest blank with string.
     *
     * @covers ::blank
     */
    public function testBlankString()
    {
        $condition = blank("ServicesContainerTest");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest blank with integer
     *
     * @covers ::blank
     */
    public function testBlankInteger()
    {
        $condition = blank(1234);
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest blank with integer zero
     *
     * @covers ::blank
     */
    public function testBlankIntegerZero()
    {
        $condition = blank(0);
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest blank with null
     *
     * @covers ::blank
     */
    public function testBlankNull()
    {
        $condition = blank(null);
        $this->assertTrue($condition);
    }
}
