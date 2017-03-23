<?php

use Illuminate\Container\Container;
use KennedyTedesco\HashIdsWrapper\HashIdsWrapper;

if (! function_exists('encode_id')) {
    /**
     * @param $value
     * @param string $alphabet
     * @param null $salt
     * @return string
     */
    function encode_id($value, $alphabet = 'both', $salt = null)
    {
        if (empty($salt)) {
            $instance = Container::getInstance()->make(
                HashIdsWrapper::class
            );
        } else {
            $instance = Container::getInstance()->makeWith(
                HashIdsWrapper::class, [$salt]
            );
        }

        return $instance->encode($value, $alphabet);
    }
}

if (! function_exists('decode_id')) {
    /**
     * @param $value
     * @param string $alphabet
     * @param null $salt
     * @return array|int|null
     */
    function decode_id($value, $alphabet = 'both', $salt = null)
    {
        if (empty($salt)) {
            $instance = Container::getInstance()->make(
                HashIdsWrapper::class
            );
        } else {
            $instance = Container::getInstance()->makeWith(
                HashIdsWrapper::class, [$salt]
            );
        }

        return $instance->decode($value, $alphabet);
    }
}
