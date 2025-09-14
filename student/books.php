<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('student');
require_once __DIR__ . '/../models/book.php';
require_once __DIR__ . '/../models/borrow.php';

$userId = $_SESSION['user']['user_id'] ?? null;
$borrowModel = new Borrow();
$bookModel = new Book();

// Handle borrow action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'borrow') {
    $bookId = (int)($_POST['book_id'] ?? 0);
    if ($bookId > 0) {
        try {
            $result = $borrowModel->borrowBook($userId, $bookId);
            if ($result['ok']) {
                $_SESSION['flash_success'] = 'Book borrowed successfully!';
            } else {
                $_SESSION['flash_error'] = $result['message'] ?? 'Failed to borrow book';
            }
        } catch (Exception $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
        }
        header('Location: books.php');
        exit;
    }
}

$stmt = $bookModel->getAllBooks();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - Books</title>
    <link rel="stylesheet" href="../public/css/shop.css">
    <link rel="stylesheet" href="../public/css/all.min.css">
</head>

<body>
    <div class="container" style="margin-top: 50px; display: block;">
        <h2>Available Books</h2>
        <div style="margin: 20px 0;">
            <a href="borrowed.php" style="background: #111827; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block;">View My Borrowed Books</a>
        </div>
        <div class="books-grid" id="booksGrid">
            <?php foreach ($books as $row): ?>
                <div class="book-card">
                    <img class="book-cover" src="<?php echo htmlspecialchars($row['cover_url'] ?? ''); ?>" alt="">
                    <div class="book-info">
                        <h3 class="book-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="book-author">By <?php echo htmlspecialchars($row['author']); ?></p>
                        <div class="spacer"></div>
                        <?php if ((int)$row['available_copies'] > 0): ?>
                            <form method="post">
                                <input type="hidden" name="action" value="borrow">
                                <input type="hidden" name="book_id" value="<?php echo (int)$row['book_id']; ?>">
                                <button type="submit" <?php echo $userId ? '' : 'disabled'; ?>>Borrow</button>
                            </form>
                        <?php else: ?>
                            <button disabled>Not Available</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>