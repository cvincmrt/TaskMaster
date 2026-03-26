<?php

session_start();

require_once __DIR__ . "/vendor/autoload.php";

use App\Database;
use App\Task;
use App\BugTask;
use App\FeatureTask;
use App\Project;
use App\ProjectRepository;
use App\TaskRepository;
use App\ProjectController;

$connect = new Database();
$pdo = $connect->getConnection();

$projectRepo = new ProjectRepository($pdo);
$taskRepo = new TaskRepository($pdo);

$controller = new ProjectController($projectRepo, $taskRepo);