<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Start Header -->
<header>
    <div class="logo">
        <h1 class="logoName">MASS</h1>
        <span>Bookstore</span>
    </div>

    <div class="search">
        <form action="/php/BookStore/public/shop.php" method="get">
            <input type="text" name="q" id="input" placeholder="Type A Keyword" />
        </form>
    </div>

    <nav>
        <ul>
            <li><a href="/php/BookStore/public/index.php">Home</a></li>
            <li><a href="/php/BookStore/public/shop.php">Shop</a></li>

            <?php if (!empty($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['role'] === 'student'): ?>
                    <li><a href="/php/BookStore/student/index.php">Dashboard</a></li>
                <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                    <li><a href="/php/BookStore/admin/index.php">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="/php/BookStore/auth/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/php/BookStore/auth/login.php">Login</a></li>
                <li><a href="/php/BookStore/auth/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<!-- End Header -->
<?php if (!empty($_SESSION['flash_success']) || !empty($_SESSION['flash_error'])): ?>
    <div style="max-width:1200px;margin:12px auto;padding:12px 16px;border-radius:8px;<?php echo !empty($_SESSION['flash_success']) ? 'background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0;' : 'background:#fef2f2;color:#991b1b;border:1px solid #fecaca;'; ?>">
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <?php echo htmlspecialchars($_SESSION['flash_success']);
            unset($_SESSION['flash_success']); ?>
        <?php elseif (!empty($_SESSION['flash_error'])): ?>
            <?php echo htmlspecialchars($_SESSION['flash_error']);
            unset($_SESSION['flash_error']); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>