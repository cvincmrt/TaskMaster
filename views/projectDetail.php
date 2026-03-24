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

$taskRepo = new TaskRepository($pdo);

if(isset($_GET["projectId"])){
    $projectRepo = new ProjectRepository($pdo);
    $project = $projectRepo->getOne((int)$_GET["projectId"]);
  

    $tasksList = $taskRepo->getTasksByProjectId((int)$_GET["projectId"]);
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
  </head>
  <body>
    
    <div class="container p-4">
       <div class="mb-5">
            <h1 class="badge text-bg-primary fs-1 mb-5">Project</h1>
            <h3>Project name: <?= $project->getName(); ?></h3>
            <p class="fs-4">Description: <?= $project->getDescription(); ?></p>
            <span>Create at: <?= $project->getCreatedAt(); ?></span>
      </div>

        <?php if(isset($tasksList)): ?>
            <h1>Tasks</h1>
                <table class="table ">
                    <tr>    
                        <th>Title</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Priority</th>
                    </tr>

                    <?php foreach($tasksList as $task): ?>
                        <tr>
                            <td><?= $task->getTitle(); ?></td>
                            <td><?= $task->getStatus(); ?></td>
                            <td><?= $task->getType(); ?></td>
                            <td>
                                <span class="badge <?= ($task instanceof BugTask) ? "bg-danger" : "bg-primary"; ?>">
                                    <?= $task->getCalculatedPriority(); ?>
                                </span>  
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
        <?php endif ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="main.js"></script>
    <script>
        setTimeout(function() {
        var msg = document.getElementById('msg');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 3000);
    </script>
  </body>
</html>    
