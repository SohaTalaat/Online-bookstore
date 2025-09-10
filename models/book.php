<?php

require 'basemodel.php';

class Book extends BaseModel
{

    protected $table = 'books';

    public $id;
    public $title;
    public $author;
    public $description;
    public $total_copies;
    public $available_copies;

    // Add Book To db from API
    public function createBook($bookData)
    {
        if (is_string($bookData)) {
            $bookData = json_decode($bookData, true);
        }

        $sql = "INSERT INTO books (title, author, description, total_copies, available_copies)
            VALUES (:title, :author, :description, :total_copies, :available_copies)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':title', $bookData['title']);
        $stmt->bindParam(':author', $bookData['author']);
        $stmt->bindParam(':description', $bookData['description']);
        $stmt->bindParam(':total_copies', $bookData['total_copies']);
        $stmt->bindParam(':available_copies', $bookData['available_copies']);

        return $stmt->execute();
    }

    // Add Book To db
    public function createAdminBook($data)
    {
        $query = "INSERT INTO $this->table SET title = :title, author = :author, description = :description, total_copies = :total_copies, available_copies = :available_copies";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":author", $data['author']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":total_copies", $data['total_copies']);
        $stmt->bindParam(":available_copies", $data['available_copies']);

        return $stmt->execute();
    }

    public function updateBook($id, $data)
    {
        $query = "UPDATE $this->table 
        SET title =:title, author = :author, description =: description,
        total_copies = :total_copies, available_copies = :available_copies
        where id=:id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":title", $data['title']);
        $stmt->bindParam(":author", $data['author']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":total_copies", $data['total_copies']);
        $stmt->bindParam(":available_copies", $data['available_copies']);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function deleteBook($id)
    {
        $query = "DELETE from $this->table where id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
