<?php

namespace App\Test;

use Cake\Database\Connection;
use PHPUnit\Framework\TestCase;

class ServicesDbTest extends TestCase
{
    /**
     * Tests db instance.
     *
     * @covers ::db
     */
    public function testDb()
    {
        container()->set('db', null);
        $db = db();
        $this->assertInstanceOf(Connection::class, $db);
        container()->set('db', $db);
    }
}
