<?php

declare(strict_types=1);

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $dsn = (string) env('DB_DSN', '');
        $user = (string) env('DB_USER', '');
        $password = (string) env('DB_PASS', '');

        if ($dsn === '') {
            $host = (string) env('DB_HOST', 'localhost');
            $port = (string) env('DB_PORT', '3306');
            $name = (string) env('DB_NAME', '');
            $charset = (string) env('DB_CHARSET', 'utf8mb4');

            if ($name === '') {
                throw new RuntimeException('Database is not configured.');
            }

            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
        }

        self::$connection = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }

    public static function setConnection(?PDO $connection): void
    {
        self::$connection = $connection;
    }
}
