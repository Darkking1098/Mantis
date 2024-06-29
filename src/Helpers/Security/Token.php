<?php

namespace Mantis\Helpers\Security;

abstract class Token
{
    protected $expiry = true;
    protected $refresh = false;
    // MilliSeconds * Seconds * Minutes * Hours * Days
    const TIMEOUT = 1000 * 60 * 60;
    const REFRESH = 1000 * 60 * 70;

    static abstract function validate($token);
    abstract function generate($data);

    protected function generate_payload($payload, $encode = true)
    {
        $time = time() * 1000;
        $payload += ["issue" => $time] + ($this->expiry ? ['expiry' => $time + self::TIMEOUT] : []) + ($this->refresh ? ['refresh' => $time + self::REFRESH] : []);
        return $encode ? json_encode($payload) : $payload;
    }
    static protected function invalidTokenResponse()
    {
        return ["isValid" => false, 'msg' => "Token is invalid", "refresh" => false];
    }

    static protected function expiredTokenResponse($data, $refresh)
    {
        return ["isValid" => false, 'msg' => "Token has been expired. Kindly " . ($refresh ? "refresh token." : "login again.") . " again.", "expired" => true, "refresh" => $refresh, 'data' => $data];
    }

    static protected function validTokenResponse($data, $refresh)
    {
        return ['isValid' => true, 'data' => $data, 'refresh' => $refresh];
    }
}
