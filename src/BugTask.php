<?php

namespace App;

class BugTask extends Task
{
    public function __construct(int $projectId, int $userId, string $title, string $status, int $priority)
    {
        parent::__construct($projectId, $userId, $title, $status, "bug", $priority);
    }    
    
    public function getCalculatedPriority() :int
    {
       return $this->priority * 2; 
    }
}