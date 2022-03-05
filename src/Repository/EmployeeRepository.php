<?php

namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Project;
use App\Entity\Assigned;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Employee $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getAllEmployeeByDesc() : array
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.started_job', 'desc')
        ; 
        return $qb->getQuery()->getResult();
    }

    public function getNumberEmployee(): array{
        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(1) as employees')
    ;
        return $qb->getQuery()->getResult();
    }

    public function getSixLastEmployee() : array
    {
        $qb = $this->createQueryBuilder('p')
            ->select("
                p.id,
                p.firstname,
                p.lastname,
                project.id as projectId,
                project.name,
                assigned.time_production            
            ")
            ->join(Project::class, "project")
            ->join(Assigned::class, "assigned")
            ->where("p.id = assigned.employee")
            ->andwhere("assigned.project = project.id")
            ->orderBy('assigned.published_at', 'DESC')
            ->setMaxResults(6)
        ; 

        return $qb->getQuery()->getResult();
    }
}
