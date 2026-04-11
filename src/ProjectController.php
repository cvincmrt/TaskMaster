<?php

namespace App;

class ProjectController
{
    private ProjectRepository $projectRepo;
    private TaskRepository $taskRepo;
    private UserRepository $userRepo;

    public function __construct(ProjectRepository $projectRepository, TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->projectRepo = $projectRepository;
        $this->taskRepo = $taskRepository;
        $this->userRepo = $userRepository;
    }

    public function index()
    {
        return $this->projectRepo->getAll();
    }

    public function show(int $id)
    {
       
        return [
            "project" => $this->projectRepo->getOne($id),
            "tasks" => $this->taskRepo->getTasksByProjectId($id),
            "users" => $this->userRepo->getAllUsers()
        ];
    }

    public function login(array $data) :bool
    {
        $username = $data["username"] ?? "";
        $password = $data["password"] ?? "";

        if(empty(trim($username)) || empty(trim($password))){
            $_SESSION["error"] = "Invalid username or password.";
            return false;
        }

        $user = $this->userRepo->findByUsername($username);

        if($user && $user->verifyPassword($password)){
            $_SESSION["user_id"] = $user->getUserId();
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["role"] = $user->getRole();
            return true;
        }
        $_SESSION["error"] = "Invalid username or password.";
        return false;
    }

    public function storeProject(array $data) :bool
    {
        $name = $data["nameForm"] ?? "";
        $description = $data["descriptionForm"] ?? "";

        if(empty(trim($name)) || empty(trim($description))){
            $_SESSION["error"] = "Incorrectly filled fields";
            return false;
        }
        
        $project = new Project($name, $description);
               
        return $this->projectRepo->saveProject($project);
    }

    public function storeTask(array $data) :bool 
    {
        $task = null;

        $userId = (int)$data["userForm"] ?? 0;
        $projectId = (int)$data["projectIdForm"] ?? 0;
        $title = $data["titleForm"] ?? "";
        $status = $data["statusForm"] ?? "todo";
        $type = $data["typeForm"] ?? "";
        $priority = (int)$data["priorityForm"] ?? 1;

        if(empty(trim($title))){
            $_SESSION["error"] = "Task title cannot be empty.";
            return false;
        }

        if($userId <= 0){
            $_SESSION["error"] = "Please select a valid user.";
            return false;
        }

        $allowedType = ["bug", "feature"];
        if(!in_array($type, $allowedType)){
            $_SESSION["error"] = "Please select a task type.";
            return false;
        }

        if(!is_numeric($priority) || $priority < 1 || $priority > 3){
            $_SESSION["error"] = "Priority must be number.";
            return false;
        }
        
        if($type === "bug"){
            $task = new BugTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
            
        }elseif($type === "feature"){
            $task = new FeatureTask((int)$projectId, (int)$userId, $title, $status, (int)$priority);
        }

               
        return $this->taskRepo->saveTask($task);
    }

    public function changeStatus(array $data) :bool
    {
        $taskId = isset($data["taskId"]) ? (int)$data["taskId"] : 0;
        $newStatus = $data["statusTask"] ?? "todo";

        if($taskId <= 0){
            return false;
        }
        
        return $this->taskRepo->saveChangeStatusTask($taskId, $newStatus);
    }

    public function deleteTask(array $data) :bool
    {
        $taskId = (int)$data["taskId"] ?? "";

        return $this->taskRepo->delete($taskId);
    }

}