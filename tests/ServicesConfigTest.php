<?php

namespace App\Test;

use Odan\Config\ConfigBag;
use PHPUnit\Framework\TestCase;

class ServicesConfigTest extends TestCase
{
    protected $actualConfig = null;

    public function setUp()
    {
        $this->actualConfig = container()->get('config');
        container()->set('config', null);
    }

    /**
     * ServicesContainerTest Config.
     *
     * @covers ::config
     */
    public function testConfig()
    {
        $container = container();
        $config = config();
        $actual = $container->get('config');
        $this->assertSame($config, $actual);
        $this->assertInstanceOf(ConfigBag::class, $config);
    }

    public function tearDown()
    {
        container()->set('config', $this->actualConfig);
    }
}
