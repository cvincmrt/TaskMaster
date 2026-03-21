<?php

namespace App;

abstract class Task
{
    protected ?int $id = null;
    protected ?int $projectId = null;
    protected ?int $userId = null;
    protected string $title;
    protected string $type; // todo, doing, done, default=todo
    protected string $status; // bug, feature
    protected int $priority; // default=1

    public function __construct(int $projectId, int $userId, string $title, string $type = "todo", string $status, int $priority = 1){
        $this->projectId = $projectId;
        $this->userId = $userId;
        $this->title = $title;
        $this->type = $type;
        $this->status = $status;
        $this->priority = $priority;
    }

    abstract public function getCalculatedPriority() :int;

    // Getery

    public function getTitle() :string
    {
        return $this->title;
    }

    public function getType() :string
    {
        return $this->type;
    }

    public function getStatus() :string
    {
        return $this->status;
    }

    public function getPriority() :int
    {
        return $this->priority;
    }

}