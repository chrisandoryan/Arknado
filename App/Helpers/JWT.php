<?php

function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input)
{
    return base64_decode(strtr($input, '._-', '+/='));
}

class JWT
{
    //TODO: use more secure algorithm (such as HS256)
    private $headers = ['alg' => 'none', 'typ' => 'JWT'];
    private $secret = '';

    public function encode($data)
    {
        $headers_encoded = base64_url_encode(json_encode($this->headers));

        //TODO: prevent the JWT from being replayed using jti claims + add expiration time (exp) time
        $payload = [
            "userid" => $data['id'],
            "iat" => round(microtime(true) * 1000)
        ];
        $payload_encoded = base64_url_encode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $this->secret, true);
        $signature_encoded = base64_url_encode($signature);

        $token = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $token;
    }

    public function decode($token)
    { 
        $tokenParts = explode(".", $token);  

        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);

        $jwtHeader = json_decode($tokenHeader, true);
        $jwtPayload = json_decode($tokenPayload, true);

        return $jwtPayload;
    }
}

// https://stackoverflow.com/questions/33773477/jwt-json-web-token-in-php-without-using-3rd-party-library-how-to-sign
