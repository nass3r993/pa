<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Password Tips';
include 'templates/header.php';
?>

<div class="tips-page">
    <h1>Tips for Strong Passwords</h1>

    <div class="tips-container">
        <div class="tip-card">
            <h3>Length Matters</h3>
            <p>Use passwords that are at least 12 characters long. Longer passwords are harder to crack.</p>
        </div>

        <div class="tip-card">
            <h3>Mix Characters</h3>
            <p>Include a mix of uppercase and lowercase letters, numbers, and special characters.</p>
        </div>

        <div class="tip-card">
            <h3>Avoid Personal Info</h3>
            <p>Don't use easily guessable information like birthdates, names, or common words.</p>
        </div>

        <div class="tip-card">
            <h3>Unique Passwords</h3>
            <p>Use different passwords for different accounts. Never reuse passwords across services.</p>
        </div>

        <div class="tip-card">
            <h3>Regular Updates</h3>
            <p>Change your passwords periodically, especially for critical accounts.</p>
        </div>

        <div class="tip-card">
            <h3>Use a Password Manager</h3>
            <p>Store your passwords securely in FortiPass and generate strong, unique passwords for each account.</p>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>