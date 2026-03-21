<?php 
session_start();

require_once __DIR__ . "/../vendor/autoload.php";

use App\Database;
use App\ProjectRepository;

$connect = new Database();
$pdo = $connect->getConnection();


$repo = new ProjectRepository($pdo);

echo $repo->getAll();
