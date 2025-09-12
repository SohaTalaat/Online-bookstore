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

        <form action="login.php" method="post" onsubmit="return validateLogin(event)">
            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required minlength="6">
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

            $userModel = new User();

            // Basic rate limit by IP in session
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $_SESSION['login_attempts'] = $_SESSION['login_attempts'] ?? [];
            $attempts = $_SESSION['login_attempts'][$ip] ?? ['count' => 0, 'time' => time()];
            if ($attempts['count'] >= 5 && (time() - $attempts['time']) < 300) {
                $_SESSION['flash_error'] = 'Too many attempts. Please try again later.';
                header('Location: login.php');
                exit;
            }

            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['login_attempts'][$ip] = ['count' => 0, 'time' => time()];
                $redirect = ($user['role'] === 'admin') ? '../admin/index.php' : '../student/index.php';
                header("Location: $redirect");
                exit;
            } else {
                $attempts['count'] = ($attempts['count'] ?? 0) + 1;
                $attempts['time'] = time();
                $_SESSION['login_attempts'][$ip] = $attempts;
                $_SESSION['flash_error'] = 'Invalid email or password';
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            echo "DB Error: " . $e->getMessage();
        }
    }

    ?>
    <script>
        function validateLogin(e) {
            const email = document.getElementById('email').value.trim();
            const pass = document.getElementById('password').value;
            if (!email || !pass) {
                alert('Please fill in email and password');
                return false;
            }
            if (pass.length < 6) {
                alert('Password must be at least 6 characters');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>