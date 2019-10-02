<?php

declare(strict_types=1);

namespace KennedyTedesco\HashIdsWrapper;

use Hashids\Hashids;
use InvalidArgumentException;

final class HashIdsWrapper
{
    public const ALPHABET_LOWER = 1;
    public const ALPHABET_UPPER = 2;
    public const ALPHABET_BOTH = 3;

    private $salt;
    private $minHashLength = 8;

    private $alphabets = [
        self::ALPHABET_LOWER => 'abcdefghijklmnopqrstuvwxyz1234567890',
        self::ALPHABET_UPPER => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        self::ALPHABET_BOTH  => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    ];

    public function __construct(string $salt)
    {
        $this->salt = $salt;
    }

    public function encode($value, int $alphabet = self::ALPHABET_BOTH) : string
    {
        $this->assertValue($value);

        $hashids = new Hashids($this->salt, $this->minHashLength, $this->getAlphabet($alphabet));

        return $hashids->encode($value);
    }

    public function decode($value, int $alphabet = self::ALPHABET_BOTH) : ?array
    {
        if (! \is_string($value)) {
            return null;
        }

        $hashids = new Hashids($this->salt, \mb_strlen($value), $this->getAlphabet($alphabet));

        $value = $hashids->decode($value);

        return $value === [] ? null : $value;
    }

    private function assertValue($value) : void
    {
        if (\is_array($value)) {
            foreach ($value as $v) {
                if (\is_array($v)) {
                    throw new InvalidArgumentException('Multidimensional arrays are not accepted.');
                }

                if (! \is_int($v) || $v < 0) {
                    throw new InvalidArgumentException('Just positive integers are accepted inside arrays.');
                }
            }
        } elseif (! \is_int($value) || $value < 0) {
            throw new InvalidArgumentException('Just positive integers or arrays are accepted.');
        }
    }

    private function getAlphabet(int $alphabet) : string
    {
        if (isset($this->alphabets[$alphabet])) {
            return $this->alphabets[$alphabet];
        }

        throw new InvalidArgumentException('Invalid alphabet.');
    }
}
