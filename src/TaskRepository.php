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

        $sql = "SELECT * FROM tasks WHERE project_id = :projectId ORDER BY priority desc";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":projectId" => $projectId
            ]);
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $task = null;
            
            if($row["type"] === "bug"){
                $task = new BugTask((int)$row["project_id"], (int)$row["user_id"], $row["title"], $row["status"], (int)$row["priority"]);
                
                
            }elseif($row["type"] === "feature"){
                $task = new FeatureTask((int)$row["project_id"], (int)$row["user_id"], $row["title"], $row["status"], (int)$row["priority"]);
               
            }
            
            if($task){
                $task->setId((int)$row["id"]);
                $tasks[] = $task;
            }
        }
        
        return $tasks; 
    }

    public function saveTask(Task $task)
    {
        $sql = "INSERT INTO tasks (project_id, user_id, title, status, type, priority) VALUES (:project_id, :user_id, :title, :status, :type, :priority)";
        $stmt = $this->db->prepare($sql);

        return  $stmt->execute([
                    ":project_id" => $task->getProjectId(),
                    ":user_id" => $task->getUserId(),
                    ":title" => $task->getTitle(),
                    ":status" => $task->getStatus(),
                    ":type" => $task->getType(),
                    ":priority" => $task->getCalculatedPriority()
                ]);

    }

    public function saveChangeStatusTask($taskId, $newStatus) :bool
    {

        $sql = "UPDATE tasks SET status = :newStatus WHERE id = :taskId";

        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
                ":newStatus" => $newStatus,
                ":taskId" => $taskId    
                ]);
    }

    public function delete($taskId) :bool
    {
        $sql = "DELETE FROM tasks WHERE id = :taskId";

        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
               ":taskId" => $taskId    
                ]);
    }

}