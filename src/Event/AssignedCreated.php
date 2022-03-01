<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Assigned;

final class AssignedCreated
{
    public function __construct(private Assigned $assigned)
    {
    }

    public function getProject(): Assigned
    {
        return $this->assigned;
    }
}