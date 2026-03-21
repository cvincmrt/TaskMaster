<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private string $hostname = "localhost";
    private string $dbname = "taskmaster";
    private string $charset = "utf8mb4";

    private string $user = "root";
    private string $password = "";

    private $conn = null;

    public function getConnection()
    {
        try{
            $dns = "mysql:host={$this->hostname};dbname={$this->dbname};charset={$this->charset}";
            $this->conn = new PDO($dns,$this->user,$this->password);
        }
        catch(PDOException $e){
            die("Nepodarila sa spojit s databazou!!!").$e->getMessage();
        }
    return $this->conn;
    }
}