<?php

class Database
{

    private $host = "localhost";
    private $dbname = "bookstore";
    private $password = "Abdo01099!";
    private $username = "root";
    public $connection;

    public function getConnection()
    {
        $this->connection = null;

        try {

            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
        } catch (PDOException $e) {

            echo "Connection Error:" . $e->getMessage();
        }
        return $this->connection;
    }
}
