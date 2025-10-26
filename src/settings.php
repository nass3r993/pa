<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Settings';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        $confirm = $_POST['confirm_password'];

        if ($new === $confirm) {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();

            if (password_verify($current, $user['password'])) {
                $hashed = password_hash($new, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$hashed, $_SESSION['user_id']]);
                $success = 'Password updated successfully!';
            } else {
                $error = 'Current password is incorrect';
            }
        } else {
            $error = 'New passwords do not match';
        }
    }
}

include 'templates/header.php';
?>

<div class="settings-page">
    <h1>Account Settings</h1>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= sanitizeOutput($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= sanitizeOutput($error) ?></div>
    <?php endif; ?>

    <div class="settings-container">
        <section class="password-change">
            <h2>Change Password</h2>
            <form method="POST" class="settings-form">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </section>

        <section class="export-import">
            <h2>Import/Export Passwords</h2>
            <div class="export-section">
                <h3>Export Passwords</h3>
                <a href="export.php" class="btn btn-secondary">Export as CSV</a>
            </div>

            <div class="import-section">
                <h3>Import Passwords</h3>
                <form method="POST" action="import.php" enctype="multipart/form-data">
                    <input type="file" name="import_file" accept=".csv,.xml">
                    <button type="submit" class="btn btn-secondary">Import</button>
                </form>
            </div>
        </section>
    </div>
</div>

<?php include 'templates/footer.php'; ?>