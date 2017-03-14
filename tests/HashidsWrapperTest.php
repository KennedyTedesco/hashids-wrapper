<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use KennedyTedesco\HashidsWrapper\HashidsWrapper;

class HashidsWrapperTest extends TestCase
{
    public function testEncodeAndDecodeIntegers()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');

        $this->assertEquals('VJAeG32d', $hashids->encode(99));
        $this->assertEquals(99, $hashids->decode('VJAeG32d'));

        $this->assertEquals('VJAeG32d', $hashids->encode([99]));
        $this->assertEquals(99, $hashids->decode('VJAeG32d'));
    }

    public function testEncodeAndDecodeArrayOfIntegers()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');

        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 200]));
        $this->assertEquals([100, 200], $hashids->decode('AeGaS6z2'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testDecodeInvalidArray()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');

        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 'foo']));
        $this->assertEquals([100, 200], $hashids->decode('AeGaS6z2'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEncodingString()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');
        $this->assertEquals('VJAeG32d', $hashids->encode('99'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEncodingNegativeInteger()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');
        $this->assertEquals('VJAeG32d', $hashids->encode(-99));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEncodingFloat()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');
        $this->assertEquals('VJAeG32d', $hashids->encode(99.2));
    }

    public function testDecodeInvalidValue()
    {
        $hashids = new HashidsWrapper('1My$Foo&Salt*1');
        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 200]));

        $this->assertEquals(null, $hashids->decode('BeG7S6z9'));
        $this->assertEquals(null, $hashids->decode(''));
        $this->assertEquals(null, $hashids->decode([1, '']));
        $this->assertEquals(null, $hashids->decode(1010101010));
        $this->assertEquals(null, $hashids->decode('10101010101'));
        $this->assertEquals(null, $hashids->decode('BeG7S6z91298ashu128712'));
    }
}
