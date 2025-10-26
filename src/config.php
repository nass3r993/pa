<?php
// Database configuration
$db_host = getenv('MYSQL_HOST') ?: 'db';
$db_user = getenv('MYSQL_USER') ?: 'fortipass';
$db_pass = getenv('MYSQL_PASSWORD') ?: 'fortipass_secret';
$db_name = getenv('MYSQL_DATABASE') ?: 'fortipass';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Session configuration
session_start();

// Helper functions
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit();
    }
}

function sanitizeOutput($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}