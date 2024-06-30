<?php

namespace Mantis\Helpers\Security\Token;

use Mantis\Helpers\Security\Encoder\BASE64;
use Mantis\Helpers\Security\Encoder\HMAC;
use Mantis\Helpers\Security\Token;

class JWT extends Token
{
    protected $algo, $expiry, $refresh;

    public function __construct($algo = null, $expiry = true, $refresh = false)
    {
        $this->algo = $algo;
        $this->expiry = $expiry;
        $this->refresh = $refresh;
    }
    private function encode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], BASE64::encode($data));
    }
    private static function decode($data)
    {
        return BASE64::decode(str_replace(['+', '/', '='], ['-', '_', ''], $data));
    }
    private function header()
    {
        return self::encode(json_encode(['type' => 'JWT', 'algo' => "HS256"]));
    }
    function generate($payload)
    {
        $data = self::header() . '.' . self::encode(self::generate_payload($payload));
        $signature = HMAC::encode($data);
        return $data . '.' . $signature;
    }
    static function validate($token)
    {
        if (!$token) return ["isValid" => false, 'msg' => "Token is invalid"];
        list($header, $payload, $signature) = explode('.', $token);

        $expectedSignature = HMAC::encode($header . "." . $payload);

        if ($expectedSignature !== $signature) {
            return ["isValid" => false, 'msg' => "Token is invalid"];
        }

        $dec = json_decode(self::decode($payload), true);

        if (isset($dec['expiry']) && $dec['expiry'] < time() * 1000) {
            if (isset($dec['refresh']) && $dec['refresh'] < time() * 1000) {
                return self::expiredTokenResponse($dec, false);
            } elseif (!isset($dec['refresh'])) {
                return self::expiredTokenResponse($dec, true);
            }
        }

        return self::validTokenResponse($dec, isset($dec['refresh']) ? true : false);
    }
    function refresh($token)
    {
        $result = self::validate($token);
        if (isset($result['refresh']) && $result['refresh']) {
            return self::generate($result['data']);
        } else if ($result['success']) {
            return ["success" => false, 'msg' => "Token can not be refreshed"];
        }
        return $this->expiredTokenResponse($result['data'] ?? [], false);
    }
}
