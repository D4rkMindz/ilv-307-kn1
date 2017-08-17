<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * Class BaseTest
 */
abstract class BaseTest extends TestCase
{
    /**
     * Set up.
     *

     */
    protected function setUp()
    {
        $this->setupSession();
    }

    /**
     * Setup session.
     *

     */
    protected function setupSession()
    {
        $session = new Session(new MockArraySessionStorage());
        container()->set('session', $session);
        session()->set('user_id', 1);
    }
}
