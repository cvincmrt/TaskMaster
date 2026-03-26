<?php 
require_once __DIR__ . '/../init.php';

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])){

    if($_POST["action"] === "create"){
        $name = $_POST["nameForm"] ?? "";
        $description = $_POST["descriptionForm"] ?? "";

        $controller->store($name, $description);
        $_SESSION["success"] = "A project has been added to the database.";
        
        header("Location:index.php");
        exit;
    }
}

$projectsList = $controller->index();

include __DIR__ . "/../views/dashboard.php";

