<?php

namespace Kminek\Numbers;

use InvalidArgumentException;

/**
 * NIP
 */
class NIP extends Number implements ValueObjectInterface
{
    const WEIGHTS = '657234567';

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
        } else {
            list($checksum) = $validate;
        }

        $this->value = $value;
        $this->checksum = $checksum;
    }

    /**
     * Return prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return substr($this->value, 0, 3);
    }

    /**
     * Check if NIP is valid
     *
     * @param  string $value
     * @return false|array
     */
    public static function validate($value)
    {
        if (strlen($value) !== 10) {
            return false;
        }

        if ((int) $value === 0) {
            return false;
        }

        if (ctype_digit($value) === false) {
            return false;
        }

        $checksum = static::calculateChecksum($value);
        if ($checksum === 0) {
            return false;
        }
        if ($checksum !== (int) $value[strlen($value) - 1]) {
            return false;
        }

        return [$checksum];
    }

    /**
     * Calculate checksum
     *
     * @param  string $digits
     * @return int
     */
    public static function calculateChecksum($digits)
    {
        $weights = str_split(static::WEIGHTS);
        $digits = str_split($digits);
        $sum = 0;
        for($i = 0; $i < count($weights); $i++){
            $sum += $weights[$i] * $digits[$i];
        }
        $int = $sum % 11;
        $checksum = ($int == 10) ? 0 : $int;
        return $checksum;
    }
}
