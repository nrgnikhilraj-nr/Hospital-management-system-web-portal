<?php
/**
 * Shared helper functions
 */

session_start();

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit();
}

// Ensure the user is logged in, otherwise send to login page
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        redirect(base_url() . 'index.php');
    }
}

// Compute the base url path so links work regardless of folder depth
function base_url() {
    return '/hospital-management-system/';
}

// Sanitize output to prevent XSS when echoing user data
function clean($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Simple flash message system using session
function set_flash($message, $type = 'success') {
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
