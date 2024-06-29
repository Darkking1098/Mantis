<?php

namespace Mantis\Helpers\Security\Token;

use Mantis\Helpers\Security\Token;
use Mantis\Models\AuthToken;
use Illuminate\Support\Str;

class Mantis extends Token
{
    private const TOKEN_LENGTH = 32;
    public $expiry, $refresh;

    public function __construct($expiry = true, $refresh = false)
    {
        $this->expiry = $expiry;
        $this->refresh = $refresh;
    }

    function generate($data)
    {
        $token = new AuthToken([
            "token" => Str::random(self::TOKEN_LENGTH) . time(),
            "data" => $data,
        ] + self::generate_payload([], false));
        try {
            $token->save();
            return ["success" => true, "token" => $token->token];
        } catch (\Throwable $th) {
            return ["success" => false, "message" => "Database connection failed"];
        }
    }

    static function validate($token)
    {
        $tkn = AuthToken::where('token', $token)->first();
        if (!$tkn) return self::invalidTokenResponse();

        $token = $tkn->toArray();
        if ($token['expiry'] < time() * 1000) {
            if ($token['refresh'] < time() * 1000) {
                $tkn->delete();
                return self::expiredTokenResponse($token['data'], false);
            } else {
                return self::expiredTokenResponse($token['data'], true);
            }
        }
        return self::validTokenResponse($token['data'], $tkn['refresh'] ? true : false);
    }

    function refresh($token)
    {
        $result = $this->validate($token);
        if ($result['refresh']) {
            AuthToken::where('token', $token)->first()->delete();
            return $this->generate($result['data']);
        } else if ($result['success']) {
            return ["success" => false, 'msg' => "Token can not be refreshed"];
        }
        return $this->expiredTokenResponse($result['data'] ?? [], false);
    }
}
