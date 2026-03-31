<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

// Function to check if user is admin
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Function to get current user info
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'user_email' => $_SESSION['user_email'],
            'user_name' => $_SESSION['user_name'] ?? 'User',
            'user_role' => $_SESSION['user_role'] ?? 'user'
        ];
    }
    return null;
}

// Function to require login - redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit();
    }
}

// Function to logout user
function logoutUser() {
    session_unset();
    session_destroy();
    header('Location: ../public/hbexclusive.php?logout=success');
    exit();
}
?>
