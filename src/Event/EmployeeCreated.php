<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Employee;

final class EmployeeCreated
{
    public function __construct(private Employee $employee)
    {
    }

    public function getProject(): Employee
    {
        return $this->employee;
    }
}