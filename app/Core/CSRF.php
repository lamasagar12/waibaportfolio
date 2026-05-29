<?php

class CSRF
{
    public static function token(): string
    {
        Auth::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token()) . '">';
    }

    public static function verify(?string $token): bool
    {
        Auth::startSession();
        return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function validateOrDie(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !self::verify($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            die('Invalid CSRF token.');
        }
    }
}
