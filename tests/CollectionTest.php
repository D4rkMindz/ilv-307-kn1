<?php

namespace App\Test;

use App\Util\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Class CollectionTest
 *
 * @coversDefaultClass \App\Util\Collection
 */
class CollectionTest extends TestCase
{
    protected $tempResult = [];

    /**
     * DbBlockedUsersTest Collection::each with default values.
     *
     * @covers ::each
 */
    public function testEachDefault()
    {
        $expected = [];
        $testArray = [];

        for ($i = 0; $i < 100; $i++) {
            $testArray[$i]['stay'] = 'this should stay';
            $testArray[$i]['text'] = 'Lorem ipsum dolor sit amet';
            $expected[$i] = 'Lorem ipsum dolor sit amet';
        }

        $collection = new Collection($testArray);
        $collection->each(function ($item) {
            $this->tempResult[] = $item['text'];
        });

        $this->assertSame($expected, $this->tempResult);
    }

    /**
     * DbBlockedUsersTest Collection::map with default values.
     *
     * @covers ::map
 */
    public function testMapDefault()
    {
        $expected = [];
        $testArray = [];

        for ($i = 0; $i < 100; $i++) {
            $testArray[$i]['remove'] = 'this should be removed';
            $testArray[$i]['stay'] = 'this should stay';
            $testArray[$i]['change'] = 'Lorem ipsum dolor sit amet';
            $expected[$i]['stay'] = 'this should stay';
            $expected[$i]['change'] = 'changed';
        }

        $collection = new Collection($testArray);
        $actual = $collection->map(function ($item) {
            unset($item['remove']);
            $item['change'] = 'changed';

            return $item;
        });

        $actualArray = $actual->getArrayCopy();

        $this->assertSame($expected, $actualArray);
    }

    /**
     * DbBlockedUsersTest Collection::filter with default values.
     *
     * @covers ::filter
     */
    public function testFilterDefault()
    {
        $expected = [];
        $testArray = [];

        for ($i = 0; $i < 100; $i++) {
            $value = $i * ($i + $i);
            $testArray[] = $value;
            if ($value >= 1000) {
                $expected[$i] = $value;
            }
        }

        $collection = new Collection($testArray);
        $actual = $collection->filter(function ($item) {
            if ($item >= 1000) {
                return true;
            }

            return false;
        });

        $actualArray = $actual->getArrayCopy();

        $this->assertSame($expected, $actualArray);
    }

    /**
     * DbBlockedUsersTest Collection::reduce with default values.
     *
     * @covers ::reduce
     */
    public function testReduceDefault()
    {
        $expected = 0;
        $testArray = [];

        for ($i = 0; $i < 100; $i++) {
            $testArray[$i]['counter'] = $i;
            $testArray[$i]['text'] = 'Lorem ipsum dolor sit amet';
            $expected += $i;
        }

        $collection = new Collection($testArray);
        $actual = $collection->reduce(function ($carry, $item) {
            $result = $carry + $item['counter'];

            return $result;
        });

        $this->assertSame($expected, $actual);
    }
}
