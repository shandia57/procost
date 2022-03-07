<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\Assigned;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    private $date;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
        $this->date = new \DateTime('now');
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Project $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getAllProjectByDesc() : array
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.create_at', 'desc')
        ; 
        return $qb->getQuery()->getResult();
    }


    public function getNumberProjectInProgress(): array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(1) as project')
        ->where("p.delivery IS NULL ")
    ;
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getNumberProjectDone(): array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(1) as project')
        ->where("p.delivery IS NOT NULL ")
    ;
        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getLastFiveProject(): array
    {
        $qb = $this->createQueryBuilder('p')
        ->orderBy('p.create_at', 'DESC')
    ;
        return $qb->getQuery()->getResult();
    }

    public function getAllProjectWithCostProduction(): array
    {
        $qb = $this->createQueryBuilder('p')
        ->select("p.id,
            SUM(employee.cost * assigned.time_production) as cost, 
            p.name, 
            p.create_at, 
            p.delivery,
            p.price"
        )
        ->join(Assigned::class, "assigned")
        ->join(Employee::class, "employee")
        ->where("p.id = assigned.project")
        ->andWhere("assigned.employee = employee.id")
        ->groupBy('p.name')
        ->orderBy('p.delivery', 'DESC')
        ->setMaxResults(5);

    ;
        return $qb->getQuery()->getResult();
    }

    public function getAllProjectDelevereidWithCostProduction() : array
    {
        $qb = $this->createQueryBuilder('p')
        ->select("p.id,
            SUM(employee.cost * assigned.time_production) as cost, 
            p.name, 
            p.create_at, 
            p.delivery,
            p.price"
        )
        ->join(Assigned::class, "assigned")
        ->join(Employee::class, "employee")
        ->where("p.id = assigned.project")
        ->andWhere("assigned.employee = employee.id")
        ->andWhere("p.delivery != 'NULL' ")
        ->groupBy('p.name')

    ;
        return $qb->getQuery()->getResult();
    }



}
