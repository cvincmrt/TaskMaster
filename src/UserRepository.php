<?php

namespace App;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct( PDO $pdo){
        $this->db = $pdo;
    }

public function getAllUsers() :array
{
    $users = [];    
    $sql = "SELECT * FROM users";
    $stmt = $this->db->query($sql);

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $user = null;
        $user = new User($row["username"], "", $row["role"]);

        if($user){
            $user->setUserId((int)$row["id"]);
            $user->setRawPassword($row["password"]);
            $users[] = $user;
        }
    }

    return $users;
}
    
public function save(User $user) :bool
{
    $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $this->db->prepare($sql);

    $success = $stmt->execute([
        ":username" => $user->getUsername(),
        ":password" => $user->getPassword(),
        ":role" => $user->getRole()
    ]);

    if($success){
        $lastId = (int)$this->db->lastInsertId();
        $user->setUserId($lastId);
    }

    return $success;
}






}