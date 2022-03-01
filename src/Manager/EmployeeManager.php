<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Employee;
use App\Event\EmployeeCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class EmployeeManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(Employee $employee): void
    {
        $this->em->persist($employee);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new EmployeeCreated($employee));
    }
}
