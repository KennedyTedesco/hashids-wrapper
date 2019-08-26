<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use KennedyTedesco\HashIdsWrapper\HashIdsWrapper;

class HashIdsWrapperTest extends TestCase
{
    private const SALT = '1My$Foo&Salt*1';

    public function testEncodeAndDecodeIntegers() : void
    {
        $hashids = new HashIdsWrapper(self::SALT);

        $this->assertEquals('VJAeG32d', $hashids->encode(99));
        $this->assertEquals(99, $hashids->decode('VJAeG32d')[0]);

        $this->assertEquals('VJAeG32d', $hashids->encode([99]));
        $this->assertEquals(99, $hashids->decode('VJAeG32d')[0]);
    }

    public function testEncodeAndDecodeArrayOfIntegers() : void
    {
        $hashids = new HashIdsWrapper(self::SALT);

        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 200]));
        $this->assertEquals([100, 200], $hashids->decode('AeGaS6z2'));
    }

    public function testDecodeInvalidArray() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $hashids = new HashIdsWrapper(self::SALT);

        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 'foo']));
        $this->assertEquals([100, 200], $hashids->decode('AeGaS6z2'));
    }

    public function testEncodingString() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $hashids = new HashIdsWrapper(self::SALT);
        $this->assertEquals('VJAeG32d', $hashids->encode('99'));
    }

    public function testEncodingNegativeInteger() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $hashids = new HashIdsWrapper(self::SALT);
        $this->assertEquals('VJAeG32d', $hashids->encode(-99));
    }

    public function testEncodingFloat() : void
    {
        $this->expectException(InvalidArgumentException::class);

        $hashids = new HashIdsWrapper(self::SALT);
        $this->assertEquals('VJAeG32d', $hashids->encode(99.2));
    }

    public function testDecodeInvalidValue() : void
    {
        $hashids = new HashIdsWrapper(self::SALT);
        $this->assertEquals('AeGaS6z2', $hashids->encode([100, 200]));

        $this->assertEquals([], $hashids->decode('BeG7S6z9'));
        $this->assertEquals([], $hashids->decode(''));
        $this->assertEquals([], $hashids->decode([1, '']));
        $this->assertEquals([], $hashids->decode(1010101010));
        $this->assertEquals([], $hashids->decode('10101010101'));
        $this->assertEquals([], $hashids->decode('BeG7S6z91298ashu128712'));
    }
}
