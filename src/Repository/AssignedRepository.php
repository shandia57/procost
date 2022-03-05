<?php

namespace App\Repository;

use App\Entity\Assigned;
use App\Entity\Employee;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Assigned|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assigned|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assigned[]    findAll()
 * @method Assigned[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assigned::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Assigned $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Assigned $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Assigned[]
     */
    public function findAssignedPerEmployee(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
        ->where('p.employee = :id')
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }

    /**
     * @return Assigned[]
     */
    public function findAssignedPerProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
        ->where('p.project = :id')
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }


    public function countNumberEmployeeSingleProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(DISTINCT(p.employee)) as number')
        ->where('p.project = :id')
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }

    public function costProductionSingleProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('SUM(DISTINCT(em.cost)) as cost')
        ->leftJoin(Employee::class, 'em', 'WITH', 'em.id = p.employee')
        ->where('p.project = :id')
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }

    public function sumTotalTimeProduction() : array
    {
        $qb = $this->createQueryBuilder('p')
            ->select("SUM(p.time_production) as time")
        ;
        return $qb->getQuery()->getResult();
    }

    public function sumTimeProductionPerProject(int $id): ?array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('SUM(p.time_production) as time')
        ->where('p.project = :id')
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }

    public function getProjectCostProduction($id): array{
        $qb = $this->createQueryBuilder('p')
        ->select("SUM(employee.cost * p.time_production) as cost")
        ->join(Project::class, "project")
        ->join(Employee::class, "employee")
        ->where('p.project = :id')
        ->andWhere("project.id = p.project")
        ->andWhere("p.employee = employee.id")
        ->setParameter('id', $id)
    ;
        return $qb->getQuery()->getResult();
    }



}
