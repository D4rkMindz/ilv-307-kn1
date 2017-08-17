<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;

class ServicesMailerTest extends TestCase
{
    /**
     * ServicesContainerTest Mailer.
     *
     * @covers ::mailer
     */
    public function testMailer()
    {
        $mailer = mailer();
        $actual = container()->get('mailer');
        $this->assertSame($mailer, $actual);
        $this->assertInstanceOf(\PHPMailer::class, $mailer);
    }
}
