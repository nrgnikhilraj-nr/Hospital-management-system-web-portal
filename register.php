<?php
require_once __DIR__ . '/includes/functions.php';
if (isset($_SESSION['user_id'])) {
    redirect(base_url() . 'dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MediCare HMS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card row g-0">
        <div class="col-md-5 auth-brand">
            <i class="fa-solid fa-user-plus"></i>
            <h2 class="mt-3">Join MediCare HMS</h2>
            <p class="mb-0">Create a staff account to manage patients, appointments, billing and inventory.</p>
        </div>
        <div class="col-md-7 auth-form">
            <h4 class="mb-1">Create account</h4>
            <p class="text-muted mb-4">Fill in the details below</p>

            <?php $flash = get_flash(); ?>
            <?php if ($flash): ?>
                <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?>">
                    <?php echo clean($flash['message']); ?>
                </div>
            <?php endif; ?>

            <form action="register_process.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" minlength="6" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa-solid fa-user-plus"></i> Register
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                Already have an account? <a href="index.php">Login here</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
