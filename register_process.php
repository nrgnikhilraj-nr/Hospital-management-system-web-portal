<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';
    $role      = $_POST['role'] === 'admin' ? 'admin' : 'staff';

    if ($full_name === '' || $username === '' || strlen($password) < 6) {
        set_flash('Please fill all fields correctly. Password must be at least 6 characters.', 'error');
        redirect(base_url() . 'register.php');
    }

    // Check duplicate username
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        set_flash('Username already exists. Please choose another.', 'error');
        redirect(base_url() . 'register.php');
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$full_name, $username, $hashed, $role]);

    set_flash('Registration successful! Please login.', 'success');
    redirect(base_url() . 'index.php');
} else {
    redirect(base_url() . 'register.php');
}
