<?php

namespace Kminek\Numbers\Tests;

use Kminek\Numbers\REGON;

class REGONTest extends TestCase
{
    /**
     * @dataProvider dpGenerateInvalidRegons
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionOnInvalidInput($regon)
    {
        REGON::create($regon);
    }

    public function testGetChecksum()
    {
        $this->assertEquals(5, REGON::create('123456785')->getChecksum());
        $this->assertEquals(7, REGON::create('12345678512347')->getChecksum());
    }

    public function dpGenerateInvalidRegons()
    {
        return [
            ['23456785'], // invalid length
            ['123456785123477'], // invalid length
            ['123456781'], // invalid checksum
        ];
    }
}
