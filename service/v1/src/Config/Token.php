<?php

function getToken($user, $verif)
{
    // Time Zone
    date_default_timezone_set('CET');
    // Create token header as a JSON string
    $header = json_encode(['type' => 'JWT', 'algo' => 'HS256']);
    //........................................................................
    // Create token payload as a JSON string
    switch ($verif)
    {
        case true:
            $payload = json_encode(['key' => $user[1]->key, 'auth' => $user[1]->auth, 'installation' => $user[1]->installation,
                'iat' => $user[1]->iat, 'exp' => $user[1]->exp]);
        break;
        case false:
            $payload = json_encode(['key' => $user['identifiant'], 'auth' => $user['auth'], 'installation' => $user['installation_id'],
                'iat' => date('j-m-y \a\t G:i:s'), 'exp' => 'Permanent']);
        break;
    }
    //........................................................................
    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    // Encode Payload to Base64Url String
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    // Create token signature as a JSON string
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, parse_ini_file("../src/Config/Key.ini")['secret'], false);
    //........................................................................
    switch ($verif)
    {
        case true:
            return hash_equals($user[2]->signature, $signature);
        break;
    }
    $signature = json_encode(['signature' => $signature]);
    //........................................................................
    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    //encrypt token
    return openssl_encrypt($jwt, "AES-128-CTR", parse_ini_file("../src/Config/Key.ini")['key'], 0, 1234567891011121);
}
//........................................................................
function decodeToken()
{
    //input data
    $data = json_decode(file_get_contents('php://input'));
    if(!empty($data->token))
    {
        //decrypt token
        $jwt = openssl_decrypt($data->token, "AES-128-CTR", parse_ini_file("../src/Config/Key.ini")['key'], 0, 1234567891011121);
        //test token
        if(mb_detect_encoding($jwt, ['ASCII', 'UTF-8'], true))
        {
            //decode
            $jwtDecode = ['0' => json_decode(base64_decode(explode('.', $jwt)[0])),
                '1' => json_decode(base64_decode(explode('.', $jwt)[1])),
                '2' => json_decode(base64_decode(explode('.', $jwt)[2]))
            ];
            return $jwtDecode;
        }
    }
    return false;
}
//........................................................................
function authToken()
{
    //decode token
    $jwt = decodeToken();
    //test signature
    if($jwt != false && getToken($jwt, true))
    {
        return $jwt[1]->auth;
    }
    return "null";
}
        