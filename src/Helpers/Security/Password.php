<?php

namespace Mantis\Helpers\Security;

class Password
{
    
    static function generate($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    static function validate($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
