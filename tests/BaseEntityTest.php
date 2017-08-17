<?php

namespace App\Test;

use App\Entity\BaseEntity;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Zend\Hydrator\ObjectProperty as Hydrator;

/**
 * Class EntityTest
 *
 * @coversDefaultClass \App\Entity\BaseEntity
 */
class BaseEntityTest extends TestCase
{
    /** @var array $testRow with test-data */
    protected $testRow = [
        'key1' => 'value1',
        'key2' => 'value2',
        'key3' => 'value3',
    ];

    /**
     * DbBlockedUsersTest Constructor
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $actual = new BaseEntity($this->testRow);
        $this->assertInstanceOf(BaseEntity::class, $actual);
    }

    public function testHydrator()
    {
        $container = container();
        $container->set('hydrator', null);
        new BaseEntity($this->testRow);
        $actual = $container->get('hydrator');
        $this->assertInstanceOf(Hydrator::class, $actual);
        $namingStrategy = $actual->getNamingStrategy();
        $this->assertInstanceOf(UnderscoreNamingStrategy::class, $namingStrategy);
    }

    /**
     * DbBlockedUsersTest toJson() function.
     *
     * @covers ::__construct
     * @covers ::toJson
     * @covers ::getHydrator
     */
    public function testToJson()
    {
        $baseEntity = new BaseEntity($this->testRow);
        $actual = $baseEntity->toJson();
        $expected = json_encode($this->testRow);
        $this->assertSame($expected, $actual);
    }

    /**
     * DbBlockedUsersTest toArray() function.
     *
     * @covers ::__construct
     * @covers ::toArray
     * @covers ::getHydrator
     */
    public function testToArray()
    {
        $baseEntity = new BaseEntity($this->testRow);
        $actual = $baseEntity->toArray();
        $expected = $this->testRow;
        $this->assertSame($expected, $actual);
    }
}
