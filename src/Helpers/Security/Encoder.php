<?php

namespace Mantis\Helpers\Security;

abstract class Encoder
{
    protected const KEY = "KUM@R:1S:R0CK1N6";

    static abstract function encode($data, $algo);
    static abstract function decode($data, $algo);

    static function verify($encoded, $data, $algo = 0)
    {
        return static::encode($data, $algo) == $encoded;
    }
}
