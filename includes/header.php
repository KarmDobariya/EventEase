<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - EventEase' : 'EventEase - Event Registration Made Easy'; ?></title>
    <link rel="stylesheet" href="<?php echo isset($base_url) ? $base_url : ''; ?>/assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo isset($base_url) ? $base_url : ''; ?>/index.php">
                    <span class="brand-logo">🎉</span>
                    <span class="brand-name">EventEase</span>
                </a>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/index.php">Home</a></li>
                <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/about.html">About</a></li>
                <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/user/dashboard.php">Dashboard</a></li>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/logout.php" class="btn-logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/login.php" class="btn-login">Login</a></li>
                    <li><a href="<?php echo isset($base_url) ? $base_url : ''; ?>/register.php" class="btn-register">Register</a></li>
                <?php endif; ?>
            </ul>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>
