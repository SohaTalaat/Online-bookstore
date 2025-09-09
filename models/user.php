<?php

require 'basemodel.php';

class User extends BaseModel
{

    protected $table = "user";

    public $id;
    public $name;
    public $email;
    public $student_id;
    public $password;
    public $role;
    public $phone;
    public $address;


    // Add users to db
public function createUser($data)
{
    $query = "INSERT INTO $this->table 
              SET name = :name, email = :email, student_id = :student_id, 
                  password = :password, role = :role, phone = :phone, address = :address";
    $stmt = $this->db->prepare($query);

    $stmt->bindParam(":name", $data['name']);
    $stmt->bindParam(":email", $data['email']);

    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt->bindParam(":password", $hashedPassword);

    $stmt->bindParam(":student_id", $data['student_id']);
    $stmt->bindParam(":role", $data['role']);
    $stmt->bindParam(":phone", $data['phone']);
    $stmt->bindParam(":address", $data['address']);

    return $stmt->execute();
}


    // Get emails from db
    public function findByEmail($email)
    {
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Profile data
    public function updateProfile($id, $data)
    {
        $query = "UPDATE $this->table SET name = :name, email = :email, phone = :phone, address = :address WHERE user_id = :id";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":address", $data['address']);

        return $stmt->execute();
    }

    // Get student Data
    public function getAllStudents()
    {
        $query = "SELECT * FROM $this->table WHERE role = 'student' ";
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get student by Id
    public function getStudentById($student_id)
    {
        $query = "SELECT * FROM $this->table WHERE student_id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $student_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verify Password
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
