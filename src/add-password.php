<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Add Password';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if ($name && $username && $password) {
        // INTENTIONAL VULN: Server-Side Template Injection
        $template = "New password entry: $name";
        eval('$processed_name = "' . $template . '";');

        $stmt = $pdo->prepare("INSERT INTO passwords (user_id, name, username, password, notes) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $processed_name, $username, $password, $notes])) {
            $success = 'Password added successfully!';
        } else {
            $error = 'Failed to add password';
        }
    } else {
        $error = 'All fields are required';
    }
}

include 'templates/header.php';
?>

<div class="add-password">
    <h1>Add New Password</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= sanitizeOutput($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= sanitizeOutput($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="add-password.php" class="password-form">
        <div class="form-group">
            <label for="name">Entry Name</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-input">
                <input type="password" id="password" name="password" required>
                <button type="button" onclick="togglePasswordVisibility()">Show</button>
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Notes (Optional)</label>
            <textarea id="notes" name="notes"></textarea>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Password</button>
        </div>
    </form>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const button = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Hide';
    } else {
        input.type = 'password';
        button.textContent = 'Show';
    }
}
</script>

<?php include 'templates/footer.php'; ?>