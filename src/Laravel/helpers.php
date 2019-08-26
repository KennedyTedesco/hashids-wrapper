<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use KennedyTedesco\HashIdsWrapper\HashIdsWrapper;

if (! \function_exists('encode_id')) {
    function encode_id($value, int $alphabet = HashIdsWrapper::ALPHABET_BOTH) : string
    {
        /** @var HashIdsWrapper $instance */
        $instance = Container::getInstance()->make(HashIdsWrapper::class);

        return $instance->encode($value, $alphabet);
    }
}

if (! \function_exists('decode_id')) {
    function decode_id($value, int $alphabet = HashIdsWrapper::ALPHABET_BOTH)
    {
        /** @var HashIdsWrapper $instance */
        $instance = Container::getInstance()->make(HashIdsWrapper::class);

        $decoded = $instance->decode($value, $alphabet);

        if (\is_array($decoded) && \count($decoded) === 1) {
            return $value[0];
        }

        return $decoded;
    }
}
