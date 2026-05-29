<?php

class Auth
{
    public static function startSession(): void
    {
        $config = require __DIR__ . '/../../config/app.php';
        if (session_status() === PHP_SESSION_NONE) {
            session_name($config['session_name']);
            session_start();
        }
    }

    public static function attempt(string $login, string $password): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM admin_users WHERE (email = ? OR username = ?) AND status = ? LIMIT 1'
        );
        $stmt->execute([$login, $login, 'active']);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_avatar'] = $user['avatar'];

            $update = $db->prepare('UPDATE admin_users SET last_login = NOW() WHERE id = ?');
            $update->execute([$user['id']]);
            return true;
        }
        return false;
    }

    public static function check(): bool
    {
        self::startSession();
        return !empty($_SESSION['admin_id']);
    }

    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }
        return [
            'id' => $_SESSION['admin_id'],
            'name' => $_SESSION['admin_name'] ?? 'Admin',
            'email' => $_SESSION['admin_email'] ?? '',
            'avatar' => $_SESSION['admin_avatar'] ?? null,
        ];
    }

    public static function id(): ?int
    {
        return self::check() ? (int)$_SESSION['admin_id'] : null;
    }

    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function requireAuth(): void
    {
        if (!self::check()) {
            header('Location: /sagarportfolio/admin/login.php');
            exit;
        }
    }

    public static function createResetToken(string $email): ?string
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT id FROM admin_users WHERE email = ? AND status = ? LIMIT 1');
        $stmt->execute([$email, 'active']);
        $user = $stmt->fetch();
        if (!$user) {
            return null;
        }
        $token = bin2hex(random_bytes(32));
        $update = $db->prepare('UPDATE admin_users SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = ?');
        $update->execute([$token, $user['id']]);
        return $token;
    }

    public static function resetPassword(string $token, string $password): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT id FROM admin_users WHERE reset_token = ? AND reset_expires > NOW() LIMIT 1');
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        if (!$user) {
            return false;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $update = $db->prepare('UPDATE admin_users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?');
        return $update->execute([$hash, $user['id']]);
    }
}
