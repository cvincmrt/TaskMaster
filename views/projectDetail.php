<?php
require_once __DIR__ . '/../init.php';

use App\BugTask;
use App\FeatureTask;

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])){

    if($_POST["action"] === "create"){
      
        $projectId = $controller->addTask($_POST);

        $_SESSION["success"] = "The task has been added to the project.";
        
        header("Location:projectDetail.php?projectId=".$projectId);
        exit;
    }

    if($_POST["action"] === "changeStatus" && $_POST["saveTask"] === "save"){
       
        if($controller->changeStatus($_POST)){
            $_SESSION["success"] = "The task status has been changed.";
        }else{
            $_SESSION["error"] = "The task status has not been changed.";
        }
        
        header("Location:projectDetail.php?projectId=".(int)$_POST["projectId"]);
        exit;  
    }

    if($_POST["action"] === "changeStatus" && $_POST["deleteTask"] === "delete"){
        

        header("Location:projectDetail.php?projectId=".(int)$_POST["projectId"]);
        exit;  
    }
}

if(isset($_GET["projectId"])){
    $data = $controller->show((int)$_GET["projectId"]);
}else{
    header("Location: index.php");
    exit;
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
    <?php if(isset($_SESSION["success"])): ?>
            <div class="alert alert-success" id="msg" role="alert">
                <?= $_SESSION["success"]; unset($_SESSION["success"]); ?>
            </div>
        <?php elseif(isset($_SESSION["error"])): ?>
            <div class="alert alert-danger" id="msg" role="alert">
                <?= $_SESSION["error"]; unset($_SESSION["error"]); ?>
            </div>
        <?php endif ?>
    
    
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
                    <select class="form-select" aria-label="Default select example" name="priorityForm">
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
                            <form action="projectDetail.php" method="POST">

                                <input type="hidden" name="action" value="changeStatus">
                                <input type="hidden" name="taskIdForm" value="<?= $task->getId(); ?>">
                                <input type="hidden" name="projectId" value="<?= $data["project"]->getId(); ?>">

                                <td><?= $task->getTitle(); ?></td>

                                <td>
                                    <select class="form-select" aria-label="Default select example" name="statusTask">
                                        <option value="todo" <?= $task->getStatus() === "todo" ? "selected" : ""; ?>>todo</option>
                                        <option value="doing" <?= $task->getStatus() === "doing" ? "selected" : ""; ?>>doing</option>
                                        <option value="done" <?= $task->getStatus() === "done" ? "selected" : ""; ?>>done</option>                                     
                                    </select>                               
                                </td>
                                
                                <td><?= $task->getType(); ?></td>

                                <td>
                                    <span class="badge <?= ($task instanceof BugTask) ? "bg-danger" : "bg-primary"; ?>">
                                        <?= $task->getPriority(); ?>
                                    </span>  
                                </td>

                                <td>
                                    <button type="submit" name="saveTask" value="save" class="btn btn-warning">Save</button>
                                    <button type="submit" name="deleteTask" value="delete" class="btn btn-danger">Delete</button>
                                </td>

                            </form>    
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
