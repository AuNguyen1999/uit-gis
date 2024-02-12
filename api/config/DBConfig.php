<?php
// Database configuration
class Database
{

    private $username = "root";
    private $pass = "";
    private $dbname = "gis";

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->dbname, $this->username, $this->pass);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}