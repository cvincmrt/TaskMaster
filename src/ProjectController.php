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

    public function addTask(array $data) 
    {
        $task = null;

        $userId = $_POST["userIdForm"];
        $projectId = $_POST["projectIdForm"];
        $title = $_POST["titleForm"] ?? "";
        $status = $_POST["statusForm"] ?? "";
        $type = $_POST["typeForm"] ?? "";
        $priority = $_POST["priorityForm"] ?? "";
        

        if($type === "bug"){
            $task = new BugTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
        }elseif($type === "feature"){
            $task = new FeatureTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
        }

        if($task){
            $this->taskRepo->save($task);
        }
        //return 1;
    }
}