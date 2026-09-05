<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if the user is logged in.
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Require login to access a page.
 * Redirects to login.php if not authenticated.
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Check if the logged-in user is an admin.
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Require admin role and recent password verification to access a page.
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: index.php?error=unauthorized");
        exit();
    }
}

/**
 * Require the admin to have verified their password recently.
 */
function requireAdminVerification() {
    requireAdmin();
    
    $timeout = 1800; // 30 minutes in seconds
    if (!isset($_SESSION['admin_verified_at']) || (time() - $_SESSION['admin_verified_at'] > $timeout)) {
        $_SESSION['redirect_after_verify'] = $_SERVER['REQUEST_URI'];
        header("Location: admin_verify.php");
        exit();
    }
}
?>
