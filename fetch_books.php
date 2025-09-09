<?php
require_once "config/db.php";
require_once "models/book.php";

$bookModel = new Book();

$query = "new+releases"; // you can change this to 'novel', 'science', etc.
$url = "https://openlibrary.org/search.json?q=" . urlencode($query) . "&limit=20";


$json = file_get_contents($url);
$data = json_decode($json, true);

if (!empty($data['docs'])) {
    foreach ($data['docs'] as $doc) {
        $bookData = [
            'title' => $doc['title'] ?? 'Untitled',
            'author' => $doc['author_name'][0] ?? 'Unknown',
            'description' => $doc['first_sentence'][0] ?? 'No description',
            'total_copies' => 5,
            'available_copies' => 5
        ];

        $bookModel->createBook($bookData);
    }
    echo "Books inserted successfully!";
} else {
    echo "No data found from API.";
}
