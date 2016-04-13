<?php

namespace Kminek\Numbers;

use InvalidArgumentException;

/**
 * NRB
 */
class NRB extends Number implements ValueObjectInterface
{
    /**
     * Constructor
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $validate = static::validate($value);

        if ($validate === false) {
            throw new InvalidArgumentException('Invalid value: ' . $value);
        }

        $this->value = $value;
        $this->checksum = (int) substr($value, 0, 2);
    }

    /**
     * Check if NRB is valid
     *
     * @param  string $value
     * @return bool
     */
    public static function validate($value)
    {
        if (strlen($value) !== 26) {
            return false;
        }
        $w = [1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57];
        $value .= '2521';
        $value = substr($value, 2) . substr($value, 0, 2);
        $z = 0;
        for ($i = 0; $i < 30; $i++) {
            $z += $value[29 - $i] * $w[$i];
        }
        if ($z % 97 == 1) {
            return true;
        }
        return false;
    }

    /**
     * Return sort code
     *
     * @return string
     */
    public function getSortCode()
    {
        return substr($this->value, 2, 8);
    }

    /**
     * Return client code
     *
     * @return string
     */
    public function getClientCode()
    {
        return substr($this->value, -16);
    }
}
