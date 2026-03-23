<?php 
session_start();

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database;
use App\Task;
use App\BugTask;
use App\FeatureTask;
use App\Project;
use App\ProjectRepository;
use App\TaskRepository;

$connect = new Database();
$pdo = $connect->getConnection();

$projectRepo = new ProjectRepository($pdo);

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])){

    if($_POST["action"] === "create"){
        $name = $_POST["nameForm"] ?? "";
        $description = $_POST["descriptionForm"] ?? "";

        $project = new Project($name, $description);

        $projectRepo->save($project);
        $_SESSION["success"] = "A project has been added to the database.";
        
        header("Location:index.php");
        exit;
    }
}


$projectsList = $projectRepo->getAll();

$taskRepo = new TaskRepository($pdo);

if(isset($_GET["projectId"])){
    $tasksList = $taskRepo->getTasksByProjectId((int)$_GET["projectId"]);
}


include __DIR__ . "/../views/dashboard.php";

