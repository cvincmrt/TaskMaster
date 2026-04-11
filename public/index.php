<?php

require_once __DIR__."/../init.php";

$page = $_GET["page"] ?? "dashboard";

switch($page){
    case "login":
        include __DIR__."/../views/login.phtml";
        break;   

    case "dashboard":
        $projectsList = $controller->index();
        include __DIR__."/../views/dashboard.phtml";
        break;

    case "detail":
        $projectId = $_GET["projectId"] ?? null;
        $data = $controller->show((int)$projectId);
        include __DIR__."/../views/detail.phtml";
        break;

    case "save-project":
        if($_SERVER["REQUEST_METHOD"] === "POST"){

            if($controller->storeProject($_POST)){
                $_SESSION["success"] = "Project has been created.";
            }

            header("Location:index.php?page=dashboard");
            exit;
        }
        break;

    case "save-task":
        if($_SERVER["REQUEST_METHOD"] === "POST"){
             
            if($controller->storeTask($_POST)){
                $_SESSION["success"] = "The task has been added to the project.";
            }       
        
            $projectId = (int)$_POST["projectIdForm"] ?? 0;
            header("Location:index.php?page=detail&projectId=".$projectId);
            exit;
        }
        break;
    
    case "status-change-task":
        if($_SERVER["REQUEST_METHOD"] === "POST"){
        
            if($controller->changeStatus($_POST)){
                    $_SESSION["success"] = "The job status has been changed.";
            }

            $projectId = (int)$_POST["projectId"] ?? 0;
            header("Location:index.php?page=detail&projectId=".$projectId);
            exit;
        }
        break;
    
    case "delete-task":
        if($_SERVER["REQUEST_METHOD"] === "POST"){
        
            if($controller->deleteTask($_POST)){
                    $_SESSION["success"] = "The task was deleted.";
            }

            $projectId = (int)$_POST["projectId"] ?? 0;
            header("Location:index.php?page=detail&projectId=".$projectId);
            exit;
        }
        break;

    default :
        include __DIR__."/../views/404.phtml";
        break;

}