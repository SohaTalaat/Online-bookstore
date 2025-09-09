<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Smart Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css"
        rel="stylesheet"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-lg p-4 rounded-4" style="width: 450px;">
        <h2 class="text-center mb-4">Login to Your Account</h2>

        <form action="login.php" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg" name="login">Login</button>
            </div>
        </form>

        <?php if (isset($_GET['errors'])): ?>
            <div class="alert alert-danger mt-3 text-center">Invalid login. Please try again.</div>
        <?php endif; ?>
    </div>

    <?php
    session_start();
    require("../models/user.php");

    if (isset($_POST['login'])) {
        try {

            $userModel = new User($connection);
            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email']   = $user['email'];
                $_SESSION['role']    = $user['role'];

                header("Location: ../admin/index.php");
                exit;
            } else {
                header("Location: login.php?errors=1");
                exit;
            }
        } catch (PDOException $e) {
            echo "DB Error: " . $e->getMessage();
        }
    }

    ?>
</body>

</html>