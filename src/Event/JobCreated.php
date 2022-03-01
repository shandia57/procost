<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Job;

final class JobCreated
{
    public function __construct(private Job $job)
    {
    }

    public function getProject(): Job
    {
        return $this->job;
    }
}