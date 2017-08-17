<?php

namespace App\Test;

use App\Util\ValidationContext;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidationContextTest
 *
 * @coversDefaultClass \App\Util\ValidationContext
 */
class ValidationContextTest extends TestCase
{
    /**
     * DbBlockedUsersTest Constructor.
     */
    public function testConstructor()
    {
        $validationContext = new ValidationContext("ServicesContainerTest Error Message");
        $msg = $validationContext->getMessage();
        $this->assertEquals("ServicesContainerTest Error Message", $msg);
    }

    /**
     * DbBlockedUsersTest errors.
     *
     * @covers ::setError
     * @covers ::getErrors
     */
    public function testErrors()
    {
        $validationContext = new ValidationContext();
        $validationContext->setError("testField", "testErrorMessage");
        $errors = $validationContext->getErrors();
        $expected = [
            0 => [
                "message" => "testErrorMessage",
                "field" => "testField"
            ]
        ];
        $this->assertEquals($expected, $errors);
    }

    /**
     * DbBlockedUsersTest toArray.
     *
     * @covers ::setError
     * @covers ::toArray
     */
    public function testToArray()
    {
        $validationContext = new ValidationContext("ServicesContainerTest Error Message");
        $validationContext->setError("testField", "testErrorMessage");
        $expected = [
            "message" => "ServicesContainerTest Error Message",
            "errors" => [
                0 => [
                    "message" => "testErrorMessage",
                    "field" => "testField"
                ]
            ]
        ];
        $actual = $validationContext->toArray();
        $this->assertEquals($expected, $actual);
    }

    /**
     * DbBlockedUsersTest setMessage.
     *
     * @covers ::setMessage
     * @covers ::getMessage
     */
    public function testSetMessage()
    {
        $expected = "ServicesContainerTest Error Message";
        $validationContext = new ValidationContext();
        $validationContext->setMessage($expected);
        $actual = $validationContext->getMessage();
        $this->assertEquals($expected, $actual);
    }

    /**
     * DbBlockedUsersTest clear and fails.
     *
     * @covers ::clear
     * @covers ::fails
     * @covers ::success
     */
    public function testClearAndSuccess()
    {
        $validationContext = new ValidationContext("ServicesContainerTest Error Message. Should be deleted.");
        $validationContext->setError("testErrorField", "DbBlockedUsersTest error");
        $validationContext->clear();
        $success = $validationContext->success();
        $this->assertTrue($success);
        $fails = $validationContext->fails();
        $this->assertFalse($fails);
    }
}
