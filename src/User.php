<?php
namespace App;

class User
{
private ?int $userId = null;
private string $username;
private string $password;
private string $role; //  admin, manager, worker, default worker 
 
public function __construct(string $username, string $password, string $role="worker")
{
    $this->username = $username;
    $this->password = password_hash($password, PASSWORD_BCRYPT);
    $this->role = $role;
}

public function getUserId() :?int
{
    return $this->userId;
}

public function setUserId(int $userId) :void
{
    $this->userId = $userId;
}

public function getUsername() :string
{
    return $this->username;
}

public function getPassword() :string
{
    return $this->password;
}

public function setRawPassword(string $passwordHash) :void
{
    $this->password = $passwordHash;
}

public function verifyPassword(string $plainPassword) :bool
{
    return password_verify($plainPassword, $this->password);
}

public function getRole() :string
{
    return $this->role;
}

}