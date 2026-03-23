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

    public function save(Project $project)
    {
        $sql = "INSERT INTO projects (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":name" => $project->getName(),
            ":description" => $project->getDescription()
        ]);
    }

}