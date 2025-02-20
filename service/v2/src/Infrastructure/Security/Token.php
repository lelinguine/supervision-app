<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use Exception;

class Token
{
    public const AUTH_LEVELS = [
        'BASIC' => 'basic',
        'ADMIN' => 'admin'
    ];

    private function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public function generateToken(array $user): string
    {
        date_default_timezone_set('CET');
        
        $header = json_encode(['type' => 'JWT', 'algo' => 'sha256']);
        $base64UrlHeader = $this->base64UrlEncode($header);

        $payload = json_encode([
            'key' => $user['pseudo'],
            'auth' => $user['auth'],
            'iat' => date('j-m-y \a\t G:i:s')
        ]);
        $base64UrlPayload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $_ENV['HASH_SECRET'], false);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return openssl_encrypt($jwt, "AES-128-CTR", $_ENV['ENCRYPT_KEY'], 0, '1234567891011121');
    }

    public function decodeToken(string $token): array
    {
        $token = openssl_decrypt($token, "AES-128-CTR", $_ENV['ENCRYPT_KEY'], 0, '1234567891011121');
        $parts = explode('.', $token);

        $calculatedSignature = hash_hmac('sha256', $parts[0] . "." . $parts[1], $_ENV['HASH_SECRET'], false);
        $decodedSignature = base64_decode($parts[2]);
        
        if (hash_equals($calculatedSignature, $decodedSignature)) {
            return [
                'header' => json_decode(base64_decode($parts[0])),
                'payload' => json_decode(base64_decode($parts[1])),
                'signature' => $decodedSignature
            ];
        }
        return [];
    }

    public function authToken(string $token): string
    {
        $token = $this->decodeToken($token);
        return $token['payload']->auth ?? "invalid";
    }
}
