<?php

namespace Kminek\Numbers;

interface ValueObjectInterface
{
    /**
     * Return an object taking PHP native value(s) as argument(s)
     *
     * @return ValueObjectInterface
     */
    public static function create();

    /**
     * Compare two ValueObjectInterface and tell whether they can be considered equal
     *
     * @param  ValueObjectInterface $object
     * @return bool
     */
    public function equals(ValueObjectInterface $object);

    /**
     * Return a string representation of the object
     *
     * @return string
     */
    public function __toString();
}
