<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Login History';

$stmt = $pdo->prepare("SELECT * FROM login_history WHERE user_id = ? ORDER BY login_time DESC");
$stmt->execute([$_SESSION['user_id']]);
$history = $stmt->fetchAll();

include 'templates/header.php';
?>

<div class="login-history">
    <h1>Login History</h1>

    <div class="history-list">
        <?php foreach ($history as $entry): ?>
            <div class="history-item">
                <div class="login-time">
                    <?= date('F j, Y g:i A', strtotime($entry['login_time'])) ?>
                </div>
                <div class="user-agent">
                    <!-- INTENTIONAL VULN: Stored XSS -->
                    <?= $entry['user_agent'] ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>