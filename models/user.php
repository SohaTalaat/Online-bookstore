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

    function createUser($data)
    {
        $query = "INSERT INTO $this->table SET name = :name, email = :email, student_id = :student_id, password = :password, role = :role, phone = :phone, address = :address";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":password", password_hash($data['name'], PASSWORD_DEFAULT));
        $stmt->bindParam(":student_id", $data['student_id']);
        $stmt->bindParam(":role", $data['role']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":address", $data['address']);

        return $stmt->execute();
    }

    function findByEmail()
    {
        $query = "SELECT * FROM $this -> table WHERE email = :email";
        $stmt = $this->db->prepare($query);
    }
}
