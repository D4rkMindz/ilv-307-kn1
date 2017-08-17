<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;

/**
 * Class UtilInArrayRecursiveTest
 */
class UtilInArrayRecursiveTest extends TestCase
{
    /**
     * Generate array.
     *
     * @param string $valueNeeded with a value that must be in the array
     * @return array $array generated array
     */
    protected function generateArray(string $valueNeeded = ''): array
    {
        $data = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'];
        $count = rand(2, 20);
        $valueNeededPosition = 0;
        if (!empty($valueNeeded)) {
            $valueNeededPosition = rand(2, $count);
        }
        $array = [];
        for ($i = 0; $i < $count; $i++) {
            $array[] = $data;
        }

        foreach ($array as $key => $value) {
            foreach ($array[$key] as $k => $v) {
                $array[$key][$k] = [];
                $array[$key][$k] = $data;
                if (!empty($valueNeeded) && $k == 'key2' && $key == ($valueNeededPosition - 1)) {
                    $array[$key][$k] = $valueNeeded;
                }
            }
        }

        return $array;
    }

    /**
     * Test ::in_array_recursive success.
     *
     * @covers ::in_array_recursive
     */
    public function testSuccess()
    {
        $array = $this->generateArray('A value to check');
        $condition = in_array_recursive('A value to check', $array);
        $this->assertTrue($condition);
    }

    /**
     * Test ::in_array_recursive fail.
     *
     * @covers ::in_array_recursive
     */
    public function testFail()
    {
        $array = $this->generateArray();
        $condition = in_array_recursive('A value that surely does not exist in the array.', $array);
        $this->assertFalse($condition);
    }
}
