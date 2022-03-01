<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Assigned;
use App\Event\AssignedCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class AssignedManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(Assigned $assigned): void
    {
        $this->em->persist($assigned);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new AssignedCreated($assigned));
    }
}
