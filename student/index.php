<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';

require_role('student');

$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/all.min.css">
</head>

<body>
    <div class="container" style="min-height: 92vh; margin-top: 30px;">
        <h2>Welcome, <?= htmlspecialchars($user['name'] ?? 'Student'); ?>!</h2>

        <div style="display: flex; gap: 16px; flex-wrap: wrap; margin: 20px 0;">
            <a href="books.php" class="btn" style="background: #111827; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px;">
                Browse Books
            </a>
            <a href="borrowed.php" class="btn" style="background: #111827; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px;">
                My Borrowed Books
            </a>
            <a href="../public/shop.php" class="btn" style="background: #111827; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px;">
                Public Shop
            </a>
        </div>

        <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3>Quick Stats</h3>
            <p>Email: <?= htmlspecialchars($user['email'] ?? ''); ?></p>
            <p>Student ID: <?= htmlspecialchars($user['student_id'] ?? 'Not set'); ?></p>
            <p>Role: <?= htmlspecialchars($user['role'] ?? ''); ?></p>
        </div>
    </div>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>