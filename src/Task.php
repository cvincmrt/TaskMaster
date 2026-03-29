<?php

namespace App;

abstract class Task
{
    protected ?int $id = null;
    protected int $projectId;
    protected ?int $userId = null;
    protected string $title;
    protected string $type; // bug, feature
    protected string $status; // todo, doing, done, default=todo
    protected int $priority; // default=1

    public function __construct(int $projectId, int $userId, string $title, string $status = "todo", string $type, int $priority = 1){
        $this->projectId = $projectId;
        $this->userId = $userId;
        $this->title = $title;
        $this->status = $status;
        $this->type = $type;
        $this->priority = $priority;
    }

    abstract public function getCalculatedPriority() :int;

    // Getery

    public function getTitle() :string
    {
        return $this->title;
    }
    
    public function getStatus() :string
    {
        return $this->status;
    }

    public function getPriority() :int
    {
        return $this->priority;
    }

    public function getType() :string
    {
        return $this->type;
    }

    public function getId() :int
    {
        return $this->id;
    }

    public function getUserId() :int
    {
        return $this->userId;
    }

    public function getProjectId() :int
    {
        return $this->projectId;
    }

    // Settery
    
    public function setId($id){
        $this->id = $id;
    }

    public function setPriority($priority){
        $this->priority = $priority;
    }

}