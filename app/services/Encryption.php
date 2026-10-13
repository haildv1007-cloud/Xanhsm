<?php

declare(strict_types=1);

final class Encryption
{
    private const CIPHER = 'aes-256-gcm';

    private static function key(): string
    {
        $configured = (string) env('APP_ENCRYPTION_KEY', '');
        $decoded = base64_decode($configured, true);
        $key = $decoded !== false ? $decoded : $configured;

        if (strlen($key) !== 32) {
            throw new RuntimeException('APP_ENCRYPTION_KEY must contain exactly 32 bytes, optionally base64 encoded.');
        }

        return $key;
    }

    public static function encrypt(?string $plainText): ?string
    {
        if ($plainText === null || $plainText === '') {
            return null;
        }

        $iv = random_bytes(12);
        $tag = '';
        $encrypted = openssl_encrypt($plainText, self::CIPHER, self::key(), OPENSSL_RAW_DATA, $iv, $tag);

        if ($encrypted === false) {
            throw new RuntimeException('Unable to encrypt protected data.');
        }

        return base64_encode($iv . $tag . $encrypted);
    }

    public static function decrypt(?string $payload): ?string
    {
        if ($payload === null || $payload === '') {
            return null;
        }

        $decoded = base64_decode($payload, true);
        if ($decoded === false || strlen($decoded) < 29) {
            throw new RuntimeException('Invalid encrypted payload.');
        }

        $iv = substr($decoded, 0, 12);
        $tag = substr($decoded, 12, 16);
        $cipherText = substr($decoded, 28);
        $plainText = openssl_decrypt($cipherText, self::CIPHER, self::key(), OPENSSL_RAW_DATA, $iv, $tag);

        if ($plainText === false) {
            throw new RuntimeException('Unable to decrypt protected data.');
        }

        return $plainText;
    }
}
