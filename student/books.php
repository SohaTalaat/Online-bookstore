<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('student');
require_once __DIR__ . '/../models/book.php';
require_once __DIR__ . '/../models/borrow.php';

// Assume user session already set
session_start();
$userId = $_SESSION['user']['user_id'] ?? null;

$bookModel = new Book();
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
    <link rel="stylesheet" href="../public/css/responsive.css">
</head>

<body>
    <div class="container">
        <h2>Available Books</h2>
        <div class="books-grid" id="booksGrid">
            <?php foreach ($books as $row): ?>
                <div class="book-card">
                    <img class="book-cover" src="<?php echo htmlspecialchars($row['cover_url'] ?? ''); ?>" alt="">
                    <div class="book-info">
                        <h3 class="book-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="book-author">By <?php echo htmlspecialchars($row['author']); ?></p>
                        <div class="spacer"></div>
                        <?php if ((int)$row['available_copies'] > 0): ?>
                            <form method="post" action="borrowed.php">
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