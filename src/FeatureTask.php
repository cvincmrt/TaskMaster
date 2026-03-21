<?php

namespace App;

class FeatureTask extends Task
{
    public function __construct(int $projectId, int $userId, string $title, string $status, int $priority)
    {
        parent::__construct($projectId, $userId, $title, $status, "feature", $priority);
    }    
    
    public function getCalculatedPriority() :int
    {
       return $this->priority; 
    }
}