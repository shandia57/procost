<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Job;
use App\Event\JobCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class JobManager
{
    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function save(Job $job): void
    {
        $this->em->persist($job);
        $this->em->flush();

        $this->eventDispatcher->dispatch(new JobCreated($job));
    }
}
