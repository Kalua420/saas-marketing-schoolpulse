<?php
session_start();

function is_logged_in(): bool {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

// Alias for legacy calls using camelCase
function isLoggedIn(): bool {
    return is_logged_in();
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: index.php');
        exit;
    }
}

function login_admin(array $admin): void {
    session_regenerate_id(true);
    $_SESSION['admin_id']   = $admin['id'];
    $_SESSION['admin_name'] = $admin['name'];
    $_SESSION['admin_role'] = $admin['role'];
}

function logout_admin(): void {
    session_destroy();
    header('Location: index.php');
    exit;
}