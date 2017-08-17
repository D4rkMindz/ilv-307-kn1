<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;

class UtilIsEmailTest extends TestCase
{
    /**
     * DbBlockedUsersTest is_email regular
     *
     * @covers ::is_email
     */
    public function testIsEmailRegular()
    {
        $condition = is_email("test@example.com");
        $this->assertStringEndsWith(".com", $condition);
        $this->assertStringStartsWith("test", $condition);
    }

    /**
     * DbBlockedUsersTest is_email without (at)-character
     *
     * @covers ::is_email
     */
    public function testIsEmailNoAt()
    {
        $condition = is_email("testexample.com");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest is_email without top-level-domain
     *
     * @covers ::is_email
     */
    public function testIsEmailNoTopLevelDomain()
    {
        $condition = is_email("test@example");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest is_email without name
     *
     * @covers ::is_email
     */
    public function testIsEmailNoLocalPart()
    {
        $condition = is_email("@example.com");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest is_email with doubled (at)-character
     *
     * @covers ::is_email
     */
    public function testIsEmailDoubleAt()
    {
        $condition = is_email("test@@example.com");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest is_email starting with dot
     *
     * @covers ::is_email
     */
    public function testIsEmailStartWithDot()
    {
        $condition = is_email(".test@example.com");
        $this->assertFalse($condition);
    }

    /**
     * DbBlockedUsersTest is_email too long
     *
     * @covers ::is_email
     */
    public function testIsEmailTooLong()
    {
        $condition = is_email("tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac
        .tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.t
        enCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.ten
        Charac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.tenCharac.test@example.com");
        $this->assertFalse($condition);
    }
}
