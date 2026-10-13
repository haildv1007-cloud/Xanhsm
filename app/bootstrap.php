<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

/** @return array<string, string> */
function load_environment(string $path): array
{
    if (!is_file($path) || !is_readable($path)) {
        return [];
    }

    $values = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($lines === false) {
        return [];
    }

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = array_map('trim', explode('=', $line, 2));

        if ($key === '' || !preg_match('/^[A-Z][A-Z0-9_]*$/', $key)) {
            continue;
        }

        if (strlen($value) >= 2) {
            $first = $value[0];
            $last = $value[strlen($value) - 1];
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                $value = substr($value, 1, -1);
            }
        }

        $values[$key] = $value;
    }

    return $values;
}

$fileEnvironment = load_environment(BASE_PATH . '/.env');

/**
 * @param mixed $default
 * @return mixed
 */
function env(string $key, mixed $default = null): mixed
{
    global $fileEnvironment;

    $serverValue = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    $value = ($serverValue !== false && $serverValue !== null)
        ? $serverValue
        : ($fileEnvironment[$key] ?? $default);

    if (!is_string($value)) {
        return $value;
    }

    return match (strtolower($value)) {
        'true', '(true)' => true,
        'false', '(false)' => false,
        'null', '(null)' => null,
        'empty', '(empty)' => '',
        default => $value,
    };
}

$timezone = (string) env('APP_TIMEZONE', 'Asia/Ho_Chi_Minh');
date_default_timezone_set($timezone);

$isProduction = env('APP_ENV', 'production') === 'production';
ini_set('display_errors', $isProduction ? '0' : '1');
error_reporting(E_ALL);

if (PHP_SAPI !== 'cli' && session_status() !== PHP_SESSION_ACTIVE) {
    session_name('xanhsm_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $isProduction,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return '';
    }

    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/** @param mixed $value */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = '/'): string
{
    $normalized = '/' . ltrim($path, '/');
    return $normalized === '//' ? '/' : $normalized;
}

function asset(string $path): string
{
    $relative = ltrim($path, '/');
    $file = BASE_PATH . '/public/' . $relative;
    $version = is_file($file) ? (string) filemtime($file) : '1';

    return '/' . $relative . '?v=' . rawurlencode($version);
}

/** @param array<string, mixed> $data */
function render(string $view, array $data = []): void
{
    $viewPath = BASE_PATH . '/app/views/' . $view . '.php';

    if (!is_file($viewPath)) {
        throw new RuntimeException('View not found: ' . $view);
    }

    extract($data, EXTR_SKIP);
    require $viewPath;
}
