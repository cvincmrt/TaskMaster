<?php

namespace App;
use PDO;

class ProjectRepository
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getAll()
    {
        $projects = [];
        $sql = "SELECT * FROM projects";

        $stmt = $this->db->query($sql);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $project = null;

            $project = new Project($row["name"], $row["description"]);
            
            if($project){
                $project->setId((int)$row["id"]);
                $project->setCreatedAt($row["created_at"]);
                $projects[] = $project; 
            }
        }

        return $projects;
    }
}