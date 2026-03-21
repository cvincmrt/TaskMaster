<?php

namespace App;

abstract class Task
{
    protected string $title;
    protected string $status;
    protected int $priority;

    public function __construct($title, $status, $priority){
        $this->title = $title;
        $this->status = $status;
        $this->priority = $priority;
    }


}