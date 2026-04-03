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
        $sql = "SELECT projects.*, COUNT(tasks.id) as task_count 
                FROM projects
                LEFT JOIN tasks ON projects.id = tasks.project_id 
                GROUP BY projects.id";

        $stmt = $this->db->query($sql);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $project = null;

            $project = new Project($row["name"], $row["description"]);
            
            if($project){
                $project->setId((int)$row["id"]);
                $project->setCreatedAt($row["created_at"]);
                $project->setCountTasks((int)$row["task_count"]);
                $projects[] = $project; 
            }
        }

        return $projects;
    }

    public function getOne($projectId)
    {
        $project = null;

        $sql = "SELECT * FROM projects WHERE id = :projectId LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":projectId" => $projectId
        ]);

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $project = new Project($row["name"], $row["description"]);
            $project->setId((int)$row["id"]);
            $project->setCreatedAt($row["created_at"]);
            
        }

        return $project;
    }

    public function saveProject(Project $project) :bool
    {
        $sql = "INSERT INTO projects (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":name" => $project->getName(),
            ":description" => $project->getDescription()
        ]);
    }

}