<?php
require_once __DIR__ . '/includes/functions.php';
if (isset($_SESSION['user_id'])) {
    redirect(base_url() . 'dashboard.php');
}
$page_title = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MediCare HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card row g-0">
        <div class="col-md-5 auth-brand">
            <i class="fa-solid fa-hospital"></i>
            <h2 class="mt-3">MediCare HMS</h2>
            <p class="mb-0">A complete solution to manage patients, doctors, appointments, billing and inventory — built as a college mini project.</p>
        </div>
        <div class="col-md-7 auth-form">
            <h4 class="mb-1">Welcome back</h4>
            <p class="text-muted mb-4">Sign in to continue to your dashboard</p>

            <?php $flash = get_flash(); ?>
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?>">
                    <?php echo clean($flash['message']); ?>
                </div>
            <?php endif; ?>

            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
            <p class="text-center text-muted small mt-2">
                Demo login &mdash; username: <code>admin</code>, password: <code>admin123</code>
            </p>
        </div>
    </div>
</div>
</body>
</html>
