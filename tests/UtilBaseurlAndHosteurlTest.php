<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UtilBaseurlAndHosteurlTest extends TestCase
{
    /**
     * ServicesContainerTest.
     *
     * @covers ::hosturl
     * @covers ::baseurl
     */
    public function testHosturlAndBaseurl()
    {
        $server = [
            'SERVER_NAME' => 'example.com',
            'SERVER_PORT' => '80',
            'HTTPS' => 'off',
            'REQUEST_URI' => '/',
            'SCRIPT_NAME' => '/index.php'
        ];
        $request = new Request([], [], [], [], [], $server);
        container()->set('request', $request);

        $actualHosturl = hosturl();
        $this->assertSame("http://example.com", $actualHosturl);

        $actualRootBaseurl =  baseurl("/", true);
        $this->assertSame("http://example.com/", $actualRootBaseurl);

        $actualTestBaseurl = baseurl("/just/for/the/test", false);
        $this->assertSame("/just/for/the/test", $actualTestBaseurl);
    }
}
