<?php

namespace Kminek\Numbers\Tests;

use Kminek\Numbers\PESEL;

class PESELTest extends TestCase
{
    /**
     * @dataProvider dpGenerateInvalidPesels
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionOnInvalidInput($pesel)
    {
        PESEL::create($pesel);
    }

    /**
     * @dataProvider dpGetGender
     */
    public function testGetGender($pesel, $gender)
    {
        $pesel = PESEL::create($pesel);
        $this->assertEquals($gender, $pesel->getGender());
    }

    /**
     * @dataProvider dpGetGender
     */
    public function testGetChecksum($pesel)
    {
        $expected = (int) substr($pesel, PESEL::LENGTH - 1);
        $this->assertEquals($expected, PESEL::create($pesel)->getChecksum());
    }

    public function testGetSerialNumber()
    {
        $this->assertEquals('0145', PESEL::create('44051401458')->getSerialNumber());
    }

    public function testGetDate()
    {
        $this->assertEquals('1996-04-09', PESEL::create('96040932711')->getDate()->format('Y-m-d'));
    }

    public function testEquals()
    {
        $this->assertEquals(true, PESEL::create('44051401458')->equals(PESEL::create('44051401458')));
    }

    public function dpGetGender()
    {
        return [
            ['78121319174', PESEL::GENDER_MALE],
            ['49072652133', PESEL::GENDER_MALE],
            ['42102515479', PESEL::GENDER_MALE],
            ['69030903853', PESEL::GENDER_MALE],
            ['40052076204', PESEL::GENDER_FEMALE],
            ['32041454766', PESEL::GENDER_FEMALE],
            ['47040971585', PESEL::GENDER_FEMALE],
            ['77122351880', PESEL::GENDER_FEMALE],
        ];
    }

    public function dpGenerateInvalidPesels()
    {
        return [
            ['3812262350'], // too short
            ['3812262350s'], // non-digit
            ['this is not a valid pesel'],
            ['381226235022'], // too long
            ['38122623502 '], // not trimed
            ['00000000000'], // all zero
            ['38122623503'], // invalid checksum
            ['38124623500'], // invalid date
            ['44444444444'],
        ];
    }
}
