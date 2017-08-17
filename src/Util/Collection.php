<?php

namespace App\Util;

/**
 * Class Collection.
 */
class Collection extends \ArrayIterator
{
    /**
     * Each.
     *
     * Iterate trough an array, but without to expect any output. E. g. sending emails or deleting database entries.
     *
     * @param callable $func
     * @return $this
     */
    public function each(callable $func)
    {
        foreach ($this as $item) {
            $func($item);
        }

        return $this;
    }

    /**
     * Map an array.
     *
     * Iterate trough an array, but expect an output. E. g. loop through an users array to insert all emails into a new
     * array.
     *
     * @param callable $func
     * @return $this
     */
    public function map(callable $func)
    {
        foreach ($this as $key => $item) {
            $this[$key] = $func($item, $key);
        }

        return $this;
    }

    /**
     * Filter an array.
     *
     * Iterate trough an array, but only insert predefined values into a new array.
     *
     * @param callable $func
     * @return $this
     */
    public function filter(callable $func)
    {
        $toUnset = [];
        foreach ($this as $key => $item) {
            if (!$func($item, $key)) {
                //TODO get explanation why TF the $key increases by 2 (expected: increase by 1) if "$toUnset[] = $key;" is replaced with "unset($this[$key]);"
                $toUnset[] = $key;
            }
        }

        foreach ($toUnset as $key) {
            unset($this[$key]);
        }

        return $this;
    }

    /**
     * Reduce.
     *
     * Iteratively reduce the array to a single value using a callback function.
     *
     * @param callable $func
     * @param string $carry
     * @return mixed $carry
     */
    public function reduce(callable $func, $carry = null)
    {
        foreach ($this as $key => $item) {
            $carry = $func($carry, $item, $key);
        }

        return $carry;
    }
}
