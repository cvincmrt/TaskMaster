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
}