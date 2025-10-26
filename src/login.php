<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        
        // INTENTIONAL VULN: Stored XSS
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $stmt = $pdo->prepare("INSERT INTO login_history (user_id, user_agent) VALUES (?, ?)");
        $stmt->execute([$user['id'], $userAgent]);
        
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid email or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FortiPass</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Sign in to access your passwords</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= sanitizeOutput($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
            </form>

            <div class="divider">
                <span>New to FortiPass?</span>
            </div>

            <a href="register.php" class="btn btn-secondary" style="width: 100%;">Create Account</a>
        </div>
    </div>
</body>
</html>