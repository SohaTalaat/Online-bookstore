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

    // Add Book To db
    public function createBook($data)
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
}
