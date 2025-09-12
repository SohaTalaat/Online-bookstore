<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect(string $path)
{
    header("Location: {$path}");
    exit;
}

function current_user()
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['flash_error'] = 'Please login first.';
        redirect('/php/BookStore/auth/login.php');
    }
}

function require_role(string $role)
{
    require_login();
    $user = current_user();
    if (!$user || ($user['role'] ?? null) !== $role) {
        $_SESSION['flash_error'] = 'Unauthorized.';
        redirect('/php/BookStore/public/index.php');
    }
}
