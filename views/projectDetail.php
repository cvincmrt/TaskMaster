<?php
require_once __DIR__ . '/../init.php';

use App\BugTask;
use App\FeatureTask;

if(isset($_GET["projectId"])){
    $data = $controller->show((int)$_GET["projectId"]);
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])){

    if($_POST["action"] === "create"){
      
        $project_id = $controller->addTask($_POST);

        $_SESSION["success"] = "The task has been added to the project.";
        
        header("Location:projectDetail.php?projectId=".$_POST["projectId"]);
        exit;
    }
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
    <?php if(isset($_SESSION["success"])): ?>
            <div class="alert alert-success" id="msg" role="alert">
                <?= $_SESSION["success"]; unset($_SESSION["success"]); ?>
            </div>
        <?php elseif(isset($_SESSION["error"])): ?>
            <div class="alert alert-danger" id="msg" role="alert">
                <?= $_SESSION["error"]; unset($_SESSION["error"]); ?>
            </div>
        <?php endif ?>
    
    <div class="container p-4">
       <div class="mb-5">
            <h1 class="badge text-bg-primary fs-1 mb-5">Project</h1>
            <h3>Project name: <?= $data["project"]->getName(); ?></h3>
            <p class="fs-4">Description: <?= $data["project"]->getDescription(); ?></p>
            <span>Create at: <?= $data["project"]->getCreatedAt(); ?></span>
      </div>

        <form action="projectDetail.php" method="POST" class="pt-4 pb-5">
            <input type="hidden" name="action" value="create">
            <div class="row g-3">
                <input type="hidden" name="projectIdForm" value="<?= $data["project"]->getId() ;?>">
                <input type="hidden" name="userIdForm" value="1">

                <div class="col-sm-5">
                    <input type="text" class="form-control" name="titleForm" placeholder="Task title">
                </div>

                <div class="col-sm-2">
                    <input type="text" class="form-control" name="statusForm" value="todo">
                </div>

                <div class="col-sm-2">
                    <select class="form-select" aria-label="Default select example" name="typeForm">
                        <option selected>task type</option>
                        <option value="bug">bug</option>
                        <option value="feature">feature</option>
                    </select>
                </div>

                <div class="col-sm-1">
                    <select class="form-select" aria-label="Default select example" name="statusForm">
                        <option selected value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>

                <div class="col-sm-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </div>
        </form>

        <?php if(isset($data["tasks"])): ?>
            <h1>Tasks</h1>
                <table class="table ">
                    <tr>    
                        <th>Title</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Action</th>
                    </tr>

                    <?php foreach($data["tasks"] as $task): ?>
                        <tr>
                            <td><?= $task->getTitle(); ?></td>
                            <td>
                                <select class="form-select" aria-label="Default select example" name="statusTask">
                                    <option selected><?= $task->getStatus(); ?></option>
                                    <option value="doing">doing</option>
                                    <option value="done">done</option>
                                </select>                               
                            </td>
                            <td><?= $task->getType(); ?></td>
                            <td>
                                <span class="badge <?= ($task instanceof BugTask) ? "bg-danger" : "bg-primary"; ?>">
                                    <?= $task->getCalculatedPriority(); ?>
                                </span>  
                            </td>
                            <td>
                                <a href="projectDetail.php?taskId=<?= $task->getId(); ?>" class="btn btn-warning">Save</a>
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
