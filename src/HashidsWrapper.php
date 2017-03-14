<?php

namespace KennedyTedesco\HashidsWrapper;

use Hashids\Hashids;
use InvalidArgumentException;

final class HashidsWrapper
{
    /**
     * @var string
     */
    protected $salt;

    /**
     * @var int
     */
    protected $minHashLength = 8;

    /**
     * @var array
     */
    protected $alphabets = [
        'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        'lower' => 'abcdefghijklmnopqrstuvwxyz1234567890',
        'both'  => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
    ];

    /**
     * HashidsWrapper constructor.
     *
     * @param $salt
     * @throws InvalidArgumentException
     */
    public function __construct($salt)
    {
        if (! is_string($salt)) {
            throw new InvalidArgumentException('Invalid salt.');
        }

        $this->salt = $salt;
    }

    /**
     * @param $value
     * @param string $alphabet
     * @return string
     */
    public function encode($value, $alphabet = 'both')
    {
        $this->assertValue($value);

        $hashids = new Hashids(
            $this->salt, $this->minHashLength, $this->getAlphabet($alphabet)
        );

        return $hashids->encode($value);
    }

    /**
     * @param $value
     * @param string $alphabet
     * @return array|int|null
     */
    public function decode($value, $alphabet = 'both')
    {
        if (! is_string($value)) {
            return null;
        }

        $hashids = new Hashids(
            $this->salt, mb_strlen($value), $this->getAlphabet($alphabet)
        );

        return $this->normalize(
            $hashids->decode($value)
        );
    }

    /**
     * @param $value
     * @return array|int|mixed
     */
    protected function normalize($value)
    {
        if (is_array($value) && count($value) === 1) {
            return $value[0] ?? null;
        } elseif (empty($value)) {
            return null;
        }

        return $value;
    }

    /**
     * @param $value
     * @throws InvalidArgumentException
     */
    protected function assertValue($value)
    {
        if ((! is_int($value) || $value < 0) && ! is_array($value)) {
            throw new InvalidArgumentException('Just positive integers or arrays are accepted.');
        }

        if (is_array($value)) {
            foreach ($value as $v) {
                $this->assertValue($v);
            }
        }
    }

    /**
     * @param $alphabet
     * @return mixed
     */
    protected function getAlphabet($alphabet)
    {
        if (isset($this->alphabets[$alphabet])) {
            return $this->alphabets[$alphabet];
        }

        throw new InvalidArgumentException('Invalid alphabet.');
    }
}
