<?php

namespace Kminek\Numbers\Tests;

use Kminek\Numbers\NRB;

class NRBTest extends TestCase
{
    /**
     * @dataProvider dpGenerateInvalidNrbs
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorExceptionOnInvalidInput($nrb)
    {
        NRB::create($nrb);
    }

    public function testGetChecksum()
    {
        $this->assertEquals(50, NRB::create('50109013620000000036017904')->getChecksum());
    }

    public function testGetSortCode()
    {
        $this->assertEquals('10901362', NRB::create('50109013620000000036017904')->getSortCode());
    }

    public function testGetClientCode()
    {
        $this->assertEquals('0000000036017904', NRB::create('50109013620000000036017904')->getClientCode());
    }

    public function dpGenerateInvalidNrbs()
    {
        return [
            ['51109013620000000036017904'], // invalid checksum
        ];
    }
}
