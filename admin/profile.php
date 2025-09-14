<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/user.php';

$roleRequired = 'admin';
require_role($roleRequired);

$userModel = new User();
$currentUser = current_user();
$successMessage = '';
$errorMessage = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    $errors = [];

    if (empty($name) || strlen($name) < 3) {
        $errors[] = 'Name must be at least 3 characters';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required';
    }

    // Check if email is already taken by another user
    if ($email !== $currentUser['email']) {
        $existingUser = $userModel->findByEmail($email);
        if ($existingUser && $existingUser['user_id'] != $currentUser['user_id']) {
            $errors[] = 'Email is already taken by another user';
        }
    }

    if (empty($errors)) {
        $updateData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        if ($userModel->updateProfile($currentUser['user_id'], $updateData)) {
            // Update session with new data
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;
            $successMessage = 'Profile updated successfully!';
            $currentUser = $_SESSION['user'];
        } else {
            $errorMessage = 'Failed to update profile. Please try again.';
        }
    } else {
        $errorMessage = implode('<br>', $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .profile-form {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .form-group {
            margin: 15px 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn {
            background: #111827;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1f2937;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .error {
            background: #fef2f2;
            color: #991b1b;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Profile</h2>

        <?php if ($successMessage): ?>
            <div class="success"><?= $successMessage ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="error"><?= $errorMessage ?></div>
        <?php endif; ?>

        <div class="profile-form">
            <h3>Update Profile Information</h3>
            <form method="post">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($currentUser['name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3"><?= htmlspecialchars($currentUser['address'] ?? '') ?></textarea>
                </div>

                <button type="submit" name="update_profile" class="btn">Update Profile</button>
            </form>
        </div>

        <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3>Account Information</h3>
            <p><strong>User ID:</strong> <?= (int)$currentUser['user_id'] ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($currentUser['role']) ?></p>
            <p><strong>Student ID:</strong> <?= htmlspecialchars($currentUser['student_id'] ?? 'Not set') ?></p>
        </div>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>