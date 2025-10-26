<?php
require_once 'config.php';
requireLogin();

$pageTitle = 'Profile';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profile_image'])) {
        $file = $_FILES['profile_image'];
        
        // INTENTIONAL VULN: Unrestricted File Upload
        $filename = $file['name'];
        $target_path = "uploads/profile_images/" . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $stmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $stmt->execute([$target_path, $_SESSION['user_id']]);
            $success = 'Profile image updated successfully!';
        } else {
            $error = 'Failed to upload image';
        }
    }
    
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $stmt = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->execute([$name, $_SESSION['user_id']]);
        $success = 'Profile updated successfully!';
    }
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

include 'templates/header.php';
?>

<div class="profile-page">
    <h1>Your Profile</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= sanitizeOutput($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= sanitizeOutput($success) ?></div>
    <?php endif; ?>

    <div class="profile-container">
        <div class="profile-image">
            <?php if ($user['profile_image']): ?>
                <img src="<?= sanitizeOutput($user['profile_image']) ?>" alt="Profile Image">
            <?php else: ?>
                <div class="no-image">No Image</div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" class="image-upload-form">
                <input type="file" name="profile_image" accept="image/*">
                <button type="submit">Upload New Image</button>
            </form>
        </div>

        <div class="profile-details">
            <form method="POST" class="profile-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?= sanitizeOutput($user['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?= sanitizeOutput($user['email']) ?>" readonly>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>