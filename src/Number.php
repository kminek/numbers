<?php

namespace Kminek\Numbers;

/**
 * Number
 */
abstract class Number
{
    /**
     * Value
     *
     * @var string
     */
    protected $value;

    /**
     * Checksum
     *
     * @var int
     */
    protected $checksum;

    /**
     * Return an object taking PHP native value(s) as argument(s)
     *
     * @param  string $value
     * @return ValueObjectInterface
     */
    public static function create()
    {
        $value = func_get_arg(0);
        return new static($value);
    }

    /**
     * Compare
     *
     * @param  ValueObjectInterface $object
     * @return bool
     */
    public function equals(ValueObjectInterface $object)
    {
        return ((string) $this === (string) $object);
    }

    /**
     * Return checksum
     *
     * @return int
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * Return a string representation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}