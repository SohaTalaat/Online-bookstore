<?php
include __DIR__ . '/../includes/header.php';
require_once "../models/book.php";

// Use the Book model (BaseModel handles DB connection)
$bookModel = new Book();

$bookId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$book = null;

if ($bookId > 0) {
    $book = $bookModel->getBookById($bookId);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $book ? htmlspecialchars($book['title']) : "Book Details"; ?></title>
    <link rel="stylesheet" href="css/shop.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/all.min.css" />
</head>

<body>
    <div class="container">
        <?php if ($book): ?>
            <div class="book-card single-view">
                <img class="book-cover"
                    src="<?php echo htmlspecialchars($book['cover_url'] ?? 'images/placeholder.jpg'); ?>"
                    alt="<?php echo htmlspecialchars($book['title']); ?>">

                <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="book-author">By <?php echo htmlspecialchars($book['author']); ?></p>

                    <p class="book-description">
                        <?php echo htmlspecialchars($book['description'] ?? "No description available."); ?>
                    </p>

                    <p><strong>Available Copies:</strong> <?php echo (int)$book['available_copies']; ?></p>

                    <div class="spacer"></div>
                    <button class="add-cart" data-book-id="<?php echo (int)$book['book_id']; ?>">
                        Add To Cart
                    </button>
                </div>
            </div>
        <?php else: ?>
            <p>Book not found.</p>
        <?php endif; ?>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>

    <script src="js/shop.js"></script>
</body>

</html>