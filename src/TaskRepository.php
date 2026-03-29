<?php

namespace App;

use PDO;

class TaskRepository
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getTasksByProjectId(int $projectId)
    {
        $tasks = [];

        $sql = "SELECT * FROM tasks WHERE project_id = :projectId";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":projectId" => $projectId
            ]);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $task = null;
            
            if($row["type"] === "bug"){
                $task = new BugTask((int)$row["project_id"], (int)$row["user_id"], $row["title"], $row["status"], (int)$row["priority"]);
                $task->setId((int)$row["id"]);
                
            }elseif($row["type"] === "feature"){
                $task = new FeatureTask((int)$row["project_id"], (int)$row["user_id"], $row["title"], $row["status"], (int)$row["priority"]);
                $task->setId((int)$row["id"]);
            }
            
            if($task){
                $tasks[] = $task;
            }
        }
        
        return $tasks; 
    }

    public function save(Task $task)
    {
        $sql = "INSERT INTO tasks (project_id, user_id, title, status, type, priority) VALUES (:project_id, :user_id, :title, :status, :type, :priority)";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":project_id" => $task->getProjectId(),
            
        ]);

    }

}