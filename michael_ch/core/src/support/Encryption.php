<?php

namespace support;

use Exception;

class Encryption
{
    public static function ENCRYPT($value): string
    {
        $key = secret_key();
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = random_bytes($ivLength);

        $encrypted = openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);

        $payload = json_encode([
            'iv' => base64_encode($iv),
            'value' => $encrypted,
        ]);

        return base64_encode($payload);
    }

    /**
     * @throws Exception
     */
    public static function DECRYPT($payload): false|string
    {
        $key = secret_key();
        $decoded = json_decode(base64_decode($payload), true);

        if (!isset($decoded['iv'], $decoded['value'])) {
            throw new Exception('Invalid payload');
        }

        $iv = base64_decode($decoded['iv']);
        $value = $decoded['value'];

        return openssl_decrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }

    public static function ENCRYPT_PASS($value): string
    {
        $key = pass_key();
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = random_bytes($ivLength);

        $encrypted = openssl_encrypt($value, 'AES-256-CBC', $key, 0, $iv);

        $payload = json_encode([
            'iv' => base64_encode($iv),
            'value' => $encrypted,
        ]);

        return base64_encode($payload);
    }

    /**
     * @throws Exception
     */
    public static function DECRYPT_PASS($payload): false|string
    {
        $key = pass_key();
        $decoded = json_decode(base64_decode($payload), true);

        if (!isset($decoded['iv'], $decoded['value'])) {
            throw new Exception('Invalid payload');
        }

        $iv = base64_decode($decoded['iv']);
        $value = $decoded['value'];

        return openssl_decrypt($value, 'AES-256-CBC', $key, 0, $iv);
    }
}