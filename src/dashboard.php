<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Dashboard';

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM passwords WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT * FROM passwords WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent = $stmt->fetchAll();

include 'templates/header.php';
?>

<div class="dashboard">
    <h1>Welcome to FortiPass</h1>
    
    <div class="stats">
        <div class="stat-box">
            <h3>Total Passwords</h3>
            <p class="stat-number"><?= $total ?></p>
        </div>
    </div>

    <div class="recent-passwords">
        <h2>Recent Passwords</h2>
        <div class="password-list">
            <?php foreach ($recent as $pass): ?>
                <div class="password-item">
                    <h3><?= sanitizeOutput($pass['name']) ?></h3>
                    <p>Username: <?= sanitizeOutput($pass['username']) ?></p>
                    <div class="password-actions">
                        <button onclick="viewPassword(<?= $pass['id'] ?>)">View</button>
                        <button onclick="location.href='edit-password.php?id=<?= $pass['id'] ?>'">Edit</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>