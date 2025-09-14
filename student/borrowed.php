<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('student');
require_once __DIR__ . '/../models/borrow.php';

$userId = $_SESSION['user']['user_id'] ?? null;
if (!$userId) {
    echo "<p>Please login to view your borrowed books.</p>";
    exit;
}

$borrowModel = new Borrow();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $bookId = (int)($_POST['book_id'] ?? 0);
    if ($action === 'borrow' && $bookId > 0) {
        $borrowModel->borrowBook($userId, $bookId);
        header('Location: borrowed.php');
        exit;
    }
    if ($action === 'return' && $bookId > 0) {
        $borrowModel->returnBook($userId, $bookId);
        header('Location: borrowed.php');
        exit;
    }
}

$items = $borrowModel->getBorrowedByUser($userId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Borrowed Books</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/all.min.css">

</head>

<body>
    <div class="container" style="min-height: 92vh; margin-top: 50px;">
        <h2>My Borrowed Books</h2>
        <div class="books-grid">
            <?php foreach ($items as $it): ?>
                <div class="book-card">
                    <img class="book-cover" src="<?php echo htmlspecialchars($it['cover_url'] ?? ''); ?>" alt="">
                    <div class="book-info">
                        <h3 class="book-title"><?php echo htmlspecialchars($it['title']); ?></h3>
                        <p class="book-author">By <?php echo htmlspecialchars($it['author']); ?></p>
                        <p>Status: <?php echo htmlspecialchars($it['status']); ?></p>
                        <p>Borrowed at: <?php echo htmlspecialchars($it['borrow_date']); ?></p>
                        <?php if ($it['status'] === 'borrowed'): ?>
                            <form method="post">
                                <input type="hidden" name="action" value="return">
                                <input type="hidden" name="book_id" value="<?php echo (int)$it['book_id']; ?>">
                                <button type="submit">Return</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>