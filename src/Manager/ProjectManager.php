<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Project;
use App\Event\ProjectCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class ProjectManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(Project $project): void
    {
        $this->em->persist($project);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new ProjectCreated($project));
    }
}
