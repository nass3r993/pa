<?php
if (!isset($pageTitle)) {
    $pageTitle = 'FortiPass';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sanitizeOutput($pageTitle) ?> - FortiPass</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="navbar-brand">
                <i class="fas fa-shield-alt" style="color: var(--primary-color); font-size: 24px;"></i>
                <a href="dashboard.php">FortiPass</a>
            </div>
            <div class="navbar-menu">
                <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="passwords.php"><i class="fas fa-key"></i> Passwords</a>
                <a href="add-password.php"><i class="fas fa-plus-circle"></i> Add Password</a>
                <a href="tips.php"><i class="fas fa-lightbulb"></i> Tips</a>
                <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                <a href="login-history.php"><i class="fas fa-history"></i> Login History</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>
    <div class="container">