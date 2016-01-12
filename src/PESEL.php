<?php

namespace Kminek\Numbers;

use DateTime;
use InvalidArgumentException;

/**
 * PESEL
 */
class PESEL extends Number implements ValueObjectInterface
{
    const LENGTH = 11;
    const WEIGHTS = '9731973197';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_INDEX = 9;

    /**
     * Date
     *
     * @var DateTime
     */
    protected $date;

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
            list($date, $checksum) = $validate;
        }

        $this->value = $value;
        $this->date = $date;
        $this->checksum = $checksum;
    }

    /**
     * Check if PESEL is valid
     *
     * @param  string $value
     * @return false|array
     */
    public static function validate($value)
    {
        if (strlen($value) !== static::LENGTH) {
            return false;
        }

        if ((int) $value === 0) {
            return false;
        }

        if (ctype_digit($value) === false) {
            return false;
        }

        $date = static::calculateDate($value);
        if ($date === false) {
            return false;
        }

        $checksum = static::calculateChecksum($value);
        if ($checksum !== (int) $value[static::LENGTH - 1]) {
            return false;
        }

        return [$date, $checksum];
    }

    /**
     * Calculate date
     *
     * @param  string $digits
     * @return false|DateTime
     */
    public static function calculateDate($digits)
    {
        list($year, $month, $day) = array_map('intval', str_split($digits, 2));
        switch (ceil($month / 20)) {
            case 1:
                $year += 1900;
                break;
            case 2:
                $year += 2000;
                break;
            case 3:
                $year += 2100;
                break;
            case 4:
                $year += 2200;
                break;
            case 5:
                $year += 1800;
                break;
        }
        $month = $month % 20;
        $date = DateTime::createFromFormat('Y-n-j', sprintf('%s-%s-%s', $year, $month, $day));
        if (DateTime::getLastErrors()['warning_count'] > 0) {
            return false;
        }
        return $date;
    }

    /**
     * Calculate checksum
     *
     * @param  string $digits
     * @return int
     */
    public static function calculateChecksum($digits)
    {
        $digits = str_split($digits);
        $weights = str_split(static::WEIGHTS);
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $digits[$i] * $weights[$i];
        }
        return $sum % 10;
    }

    /**
     * Return gender
     *
     * @return string
     */
    public function getGender()
    {
        return ($this->value[static::GENDER_INDEX] % 2) ? static::GENDER_MALE : static::GENDER_FEMALE;
    }

    /**
     * Return serial number
     *
     * @return string
     */
    public function getSerialNumber()
    {
        return substr($this->value, 6, 4);
    }

    /**
     * Return date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
