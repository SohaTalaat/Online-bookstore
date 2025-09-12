<?php

require_once __DIR__ . '/basemodel.php';

class Book extends BaseModel
{

    protected $table = 'books';
    protected $primaryKey = 'book_id';

    public $id;
    public $title;
    public $author;
    public $description;
    public $total_copies;
    public $available_copies;
    public $cover_url;

    // Add Book To db from API
    public function createBook($bookData)
    {
        if (is_string($bookData)) {
            $bookData = json_decode($bookData, true);
        }

        $sql = "INSERT INTO {$this->table} (title, author, description, cover_url, total_copies, available_copies)
            VALUES (:title, :author, :description, :cover_url, :total_copies, :available_copies)";
        $stmt = $this->db->prepare($sql);

        $available_copies = isset($bookData['available_copies'])
            ? $bookData['available_copies']
            : (isset($bookData['total_copies']) ? $bookData['total_copies'] : 1);

        $stmt->bindParam(':title', $bookData['title']);
        $stmt->bindParam(':author', $bookData['author']);
        $stmt->bindParam(':description', $bookData['description']);
        $stmt->bindParam(':cover_url', $bookData['cover_url']);
        $stmt->bindParam(':total_copies', $bookData['total_copies']);
        $stmt->bindParam(':available_copies', $available_copies);

        return $stmt->execute();
    }

    // Add Book To db
    public function createAdminBook($data)
    {
        $query = "INSERT INTO {$this->table} SET title = :title, author = :author, description = :description, total_copies = :total_copies, available_copies = :available_copies, cover_url = :cover_url";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":author", $data['author']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":total_copies", $data['total_copies']);
        $stmt->bindParam(":available_copies", $data['available_copies']);
        $stmt->bindParam(':cover_url', $data['cover_url']);

        return $stmt->execute();
    }

    public function updateBook($id, $data)
    {
        $query = "UPDATE {$this->table} 
        SET title = :title, author = :author, description = :description,
        total_copies = :total_copies, available_copies = :available_copies, cover_url = :cover_url
        WHERE book_id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":author", $data['author']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":total_copies", $data['total_copies']);
        $stmt->bindParam(":available_copies", $data['available_copies']);
        $stmt->bindParam(':cover_url', $data['cover_url']);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function deleteBook($id)
    {
        $query = "DELETE from {$this->table} where book_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function getAllBooks()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function existsByTitleAuthor(string $title, string $author): bool
    {
        $sql = "SELECT 1 FROM {$this->table} WHERE title = :title AND author = :author LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':title' => $title, ':author' => $author]);
        return (bool)$stmt->fetchColumn();
    }

    // Get single book by id
    public function getBookById(int $book_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE book_id = :book_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Decrement available copies safely 
    public function decrementAvailable(int $book_id)
    {
        $sql = "UPDATE {$this->table}
                SET available_copies = available_copies - 1
                WHERE book_id = :book_id AND available_copies > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        return $stmt->rowCount() > 0;
    }

    // Increment available copies (used on return)
    public function incrementAvailable(int $book_id)
    {
        $sql = "UPDATE {$this->table}
                SET available_copies = available_copies + 1
                WHERE book_id = :book_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':book_id' => $book_id]);
    }
}
