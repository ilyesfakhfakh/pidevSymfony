<?php

namespace App\Repository;

use App\Entity\Planification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Paginator;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @extends ServiceEntityRepository<Planification>
 *
 * @method Planification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planification[]    findAll()
 * @method Planification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planification::class);
    }

//    /**
//     * @return Planification[] Returns an array of Planification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Planification
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function fetchPlanningByDriver($name)  {
    $em=$this->getEntityManager();
    $req=$em->createQueryBuilder()
        ->select('p')
        ->from(Planification::class, 'p')
        ->where('p.id_driver = :n')
        ->setParameter('n', $name)
        ->orderBy('p.id_driver', 'DESC')
        ->setMaxResults(10);

    $result = $req->getQuery()->getResult();
    return $result;
    
}

public function countRows(): int
    {
        return $this->entityManager
            ->createQuery('SELECT COUNT(p.idPlan) FROM App\Entity\Planification p')
            ->getSingleScalarResult();
    }

     // Custom method to fetch the first 4 plan
     public function findFirstFour(): array
     {
         return $this->createQueryBuilder('p')
             ->setMaxResults(4)
             ->getQuery()
             ->getResult();
     }
     public function findBySearchQuery($searchQuery)
    {
        return $this->createQueryBuilder('p')
            ->andWhere(' p.location LIKE :query') 
            ->setParameter('query', '%'.$searchQuery.'%')
            ->getQuery()
            ->getResult();
    }
    public function findBySearch($search)
{
    $qb = $this->createQueryBuilder('p');
    $qb->where(' p.date LIKE :search OR p.location LIKE :search')
        ->setParameter('search', '%' . $search . '%');

    return $qb->getQuery()->getResult();
}

public function findAllWithSorting($sortField, $sortOrder, $pageSize, $offset): array
{
    $queryBuilder = $this->createQueryBuilder('s')
        ->orderBy("s.{$sortField}", $sortOrder)
        ->setMaxResults($pageSize)
        ->setFirstResult($offset);

    return $queryBuilder->getQuery()->getResult();
}
public function getplanStatistics()
{
    return $this->createQueryBuilder('h')
        ->select('h.location, COUNT(h.id_plan) as count')
        ->groupBy('h.location')
        ->getQuery()
        ->getResult();
}
}
