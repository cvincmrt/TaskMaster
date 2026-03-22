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

$projects = new ProjectRepository($pdo);
$projects->getAll();

$tasks = new TaskRepository($pdo);
$tasksList = $tasks->getTasksByProjectId(1);

include __DIR__ . "/../views/dashboard.php";

