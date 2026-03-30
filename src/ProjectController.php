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

        $userId = $data["userIdForm"];
        $projectId = $data["projectIdForm"];
        $title = $data["titleForm"] ?? "";
        $status = $data["statusForm"] ?? "";
        $type = $data["typeForm"] ?? "";
        $priority = $data["priorityForm"] ?? "";
        
        

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
        $taskId = (int)$data["taskIdForm"] ?? "";
        $newStatus = $data["statusTask"] ?? "todo";
        $projectId = (int)$data["projectId"] ?? "";

        return $this->taskRepo->saveChangeStatusTask($taskId, $newStatus);
    }
}