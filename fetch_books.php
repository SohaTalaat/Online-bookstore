<?php
require_once __DIR__ . '/models/book.php';

header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

try {
    $bookModel = new Book();
    $stmt = $bookModel->getAllBooks();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($books, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch books', 'message' => $e->getMessage()]);
}
