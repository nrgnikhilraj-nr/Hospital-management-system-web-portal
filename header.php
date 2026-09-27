<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? clean($page_title) . ' | ' : ''; ?>MediCare HMS</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark top-navbar">
    <div class="container-fluid">
        <button class="btn btn-link text-white d-lg-none" id="sidebarToggle"><i class="fa fa-bars"></i></button>
        <a class="navbar-brand" href="<?php echo base_url(); ?>dashboard.php">
            <i class="fa-solid fa-hospital"></i> MediCare HMS
        </a>
        <div class="ms-auto d-flex align-items-center text-white">
            <span class="me-3"><i class="fa-solid fa-user-circle"></i> <?php echo clean($_SESSION['full_name'] ?? 'User'); ?>
                <small class="badge bg-light text-dark ms-1"><?php echo clean($_SESSION['role'] ?? ''); ?></small>
            </span>
            <a href="<?php echo base_url(); ?>logout.php" class="btn btn-sm btn-outline-light">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="wrapper">
    <?php include __DIR__ . '/sidebar.php'; ?>
    <main class="content-area">
        <?php $flash = get_flash(); ?>
        <?php if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                <?php echo clean($flash['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
<?php endif; ?>
