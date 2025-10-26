<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Passwords';
include 'templates/header.php';

$search = isset($_GET['q']) ? $_GET['q'] : '';

if ($search) {
    // INTENTIONAL VULN: SQL Injection
    $query = "SELECT * FROM passwords WHERE user_id = " . $_SESSION['user_id'] . " AND name LIKE '%" . $search . "%'";
    $stmt = $pdo->query($query);
} else {
    $stmt = $pdo->prepare("SELECT * FROM passwords WHERE user_id = ? ORDER BY name");
    $stmt->execute([$_SESSION['user_id']]);
}

$passwords = $stmt->fetchAll();
?>

<div class="passwords-page">
    <h1>Your Passwords</h1>
    
    <div class="search-box">
        <form method="GET" action="passwords.php">
            <input type="text" name="q" placeholder="Search passwords..." value="<?= sanitizeOutput($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="password-grid">
        <?php foreach ($passwords as $pass): ?>
            <div class="password-card">
                <h3><?= sanitizeOutput($pass['name']) ?></h3>
                <p class="username"><?= sanitizeOutput($pass['username']) ?></p>
                <div class="password-field">
                    <input type="password" value="<?= sanitizeOutput($pass['password']) ?>" readonly>
                    <button onclick="togglePassword(this)">Show</button>
                </div>
                <?php if ($pass['notes']): ?>
                    <p class="notes"><?= sanitizeOutput($pass['notes']) ?></p>
                <?php endif; ?>
                <div class="actions">
                    <button onclick="location.href='edit-password.php?id=<?= $pass['id'] ?>'">Edit</button>
                    <button onclick="deletePassword(<?= $pass['id'] ?>)" class="delete">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function togglePassword(button) {
    const input = button.previousElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Hide';
    } else {
        input.type = 'password';
        button.textContent = 'Show';
    }
}

function deletePassword(id) {
    if (confirm('Are you sure you want to delete this password?')) {
        location.href = 'delete-password.php?id=' + id;
    }
}
</script>

<?php include 'templates/footer.php'; ?>