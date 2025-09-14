<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
$roleRequired = 'admin';
require_role($roleRequired);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/all.min.css">
</head>

<body>
    <div class="container" style="height: 92vh;">
        <h2>Admin Dashboard</h2>
        <ul style="display:flex;gap:16px;flex-wrap:wrap;list-style:none;padding-left:0;">
            <li><a class="btn" href="books.php">Manage Books</a></li>
            <li><a class="btn" href="users.php">Manage Users</a></li>
            <li><a class="btn" href="borrowed_books.php">All Borrowed Books</a></li>
            <li><a class="btn" href="profile.php">My Profile</a></li>
        </ul>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>