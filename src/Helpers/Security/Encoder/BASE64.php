<?php

namespace Mantis\Helpers\Security\Encoder;

use Mantis\Helpers\Security\Encoder;

class BASE64 extends Encoder
{

    static function encode($data, $algo = 5)
    {
        return base64_encode($data);
    }
    
    static function decode($data, $algo = 0)
    {
        return base64_decode($data);
    }
}
