<?php
// app/helpers/AuthHelper.php

class AuthHelper
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }
    }

    public static function isLoggedIn(): bool
    {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin(string $redirectUrl = 'login.php'): void
    {
        self::startSession();
        if (!self::isLoggedIn()) {
            header("Location: $redirectUrl");
            exit;
        }
    }

    public static function login(int $userId): void
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
    }

    public static function logout(): void
    {
        self::startSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies") && !headers_sent()) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function getUserId(): ?int
    {
        self::startSession();
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }
}
