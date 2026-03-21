<?php

namespace App;

class Project
{
    private ?int $id = null;
    private string $name;
    private string $description;
 
    public function __construct(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function getName() :string
    {
        return $this->name;
    }

    public function getDescription() :string
    {
        return $this->description;
    } 

    public function getId() :?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

}