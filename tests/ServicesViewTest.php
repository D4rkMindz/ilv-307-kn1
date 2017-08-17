<?php

namespace App\Test;

use League\Plates\Engine;
use PHPUnit\Framework\TestCase;

class ServicesViewTest extends TestCase
{
    protected $actualConfig;

    public function setUp()
    {
        $container = container();
        $this->actualConfig = $container->get('config');
        $container->set('config', null);
    }

    /**
     * ServicesContainerTest View.
     *
     * @covers ::view
     */
    public function testView()
    {
        $container = container();
        $container->remove('view');

        config()->set('viewPath', __DIR__ . '/../src/View');
        config()->set('publicJsPath', __DIR__ . '/../public/js');
        config()->set('publicCssPath', __DIR__ . '/../public/css');
        $view = view();
        $actual = $container->get('engine');
        $this->assertSame($view, $actual);
        $this->assertInstanceOf(Engine::class, $view);
    }

    public function tearDown()
    {
        container()->set('config', $this->actualConfig);
    }
}
