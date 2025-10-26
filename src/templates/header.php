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
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="dashboard.php">FortiPass</a>
        </div>
        <div class="navbar-menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="passwords.php">Passwords</a>
            <a href="add-password.php">Add Password</a>
            <a href="tips.php">Tips</a>
            <a href="profile.php">Profile</a>
            <a href="settings.php">Settings</a>
            <a href="login-history.php">Login History</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="container">