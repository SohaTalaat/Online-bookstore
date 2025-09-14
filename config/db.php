<?php

class Database
{

    private $host = "localhost";
    private $dbname = "bookstore";
    private $password = "1152001&Soha";
    private $username = "root";
    public $connection;

    public function getConnection()
    {
        $this->connection = null;

        try {

            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_TIMEOUT, 30);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            echo "Connection Error:" . $e->getMessage();
        }
        return $this->connection;
    }
}
