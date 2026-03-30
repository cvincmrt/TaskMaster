<?php

namespace App;

class ProjectController
{
    private ProjectRepository $projectRepo;
    private TaskRepository $taskRepo;

    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository)
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
    }

    public function index()
    {
        return $this->projectRepo->getAll();
    }

    public function show(int $id)
    {
       
        return [
            "project" => $this->projectRepo->getOne($id),
            "tasks" => $this->taskRepo->getTasksByProjectId($id)
        ];
    }

    public function store($name, $description)
    {
        $project = new Project($name, $description);
        
        return $this->projectRepo->save($project);
    }

    public function addTask(array $data) :int 
    {
        $task = null;

        $userId = (int)$data["userIdForm"] ?? 0;
        $projectId = (int)$data["projectIdForm"] ?? 0;
        $title = $data["titleForm"] ?? "";
        $status = $data["statusForm"] ?? "todo";
        $type = $data["typeForm"] ?? "";
        $priority = (int)$data["priorityForm"] ?? 1;
        
        

        if($type === "bug"){
            $task = new BugTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
            
        }elseif($type === "feature"){
            $task = new FeatureTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
        }

        if($task){
            $this->taskRepo->createTask($task);
        }
        
        return $projectId;
    }

    public function changeStatus(array $data) :bool
    {
        $taskId = isset($data["taskIdForm"]) ? (int)$data["taskIdForm"] : 0;
        $newStatus = $data["statusTask"] ?? "todo";

        if($taskId <= 0){
            return false;
        }
        
        return $this->taskRepo->saveChangeStatusTask($taskId, $newStatus);
    }

    public function deleteTask(array $data) :bool
    {
        $taskId = (int)$data["taskIdForm"] ?? "";

        return $this->taskRepo->delete($taskId);
    }

    public function validateTask(array $data) :bool
    {
        $taskTitle = $data["titleForm"] ?? "";
        $type = $data["typeForm"] ?? "";
        $priority = $data["priorityForm"] ?? "";

        if(empty(trim($taskTitle))){
            return false;
        }

        $allowedType = ["bug", "feature"];
        if(!in_array($type, $allowedType)){
            return false;
        }

        if(!is_numeric($priority) || $priority < 1 || $priority > 3){
            return false;
        }

        return true;        
    }

}