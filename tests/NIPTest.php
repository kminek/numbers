<?php

namespace Kminek\Numbers\Tests;

use Kminek\Numbers\NIP;

class NIPTest extends TestCase
{
    /**
     * @dataProvider dpGenerateInvalidNips
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionOnInvalidInput($nip)
    {
        NIP::create($nip);
    }

    public function testGetChecksum()
    {
        $this->assertEquals(8, NIP::create('1234563218')->getChecksum());
    }

    public function testGetPrefix()
    {
        $this->assertEquals('106', NIP::create('1060000062')->getPrefix());
    }

    public function dpGenerateInvalidNips()
    {
        return [
            ['11234567890'], // invalid length
            ['1234567890'], // invalid checksum
        ];
    }
}
