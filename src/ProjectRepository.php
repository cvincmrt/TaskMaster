<?php

namespace App;
use PDO;

class ProjectRepository
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }




    public function getAll()
    {
        return "pod von";
    }
}