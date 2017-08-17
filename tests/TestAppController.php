<?php

namespace App\Test;

use App\Controller\AppController;
use PHPUnit\Framework\TestCase;

class TestAppController extends TestCase
{
    public function testAppControllerInstance()
    {
        $actual = new AppController(request(), response(), session());
        $this->assertInstanceOf(AppController::class, $actual);
    }
}
