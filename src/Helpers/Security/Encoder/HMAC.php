<?php

namespace Mantis\Helpers\Security\Encoder;

use Mantis\Helpers\Security\Encoder;

class HMAC extends Encoder
{
    private const ALGOS = [
        "md2",
        "md4",
        "md5",
        "sha1",
        "sha224",
        "sha256",
        "sha384",
        "sha512/224",
        "sha512/256",
        "sha512",
        "sha3-224",
        "sha3-256",
        "sha3-384",
        "sha3-512",
        "ripemd128",
        "ripemd160",
        "ripemd256",
        "ripemd320",
        "whirlpool",
        "tiger128,3",
        "tiger160,3",
        "tiger192,3",
        "tiger128,4",
        "tiger160,4",
        "tiger192,4",
        "snefru",
        "snefru256",
        "gost",
        "gost - crypto",
        "haval128,3",
        "haval160,3",
        "haval192,3",
        "haval224,3",
        "haval256,3",
        "haval128,4",
        "haval160,4",
        "haval192,4",
        "haval224,4",
        "haval256,4",
        "haval128,5",
        "haval160,5",
        "haval192,5",
        "haval224,5",
        "haval256,5"
    ];
    static function encode($data, $algo = 5)
    {
        return hash_hmac(gettype($algo) == 'integer' ? self::ALGOS[$algo] : $algo, $data, config("mantis.app_id", self::KEY));
    }

    // This can not be decoded
    static function decode($data, $algo = 0)
    {
        return null;
    }
}
