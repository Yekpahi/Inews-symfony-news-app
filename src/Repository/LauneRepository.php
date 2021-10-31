<?php

namespace App\Repository;

use App\Entity\Laune;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Laune|null find($id, $lockMode = null, $lockVersion = null)
 * @method Laune|null findOneBy(array $criteria, array $orderBy = null)
 * @method Laune[]    findAll()
 * @method Laune[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LauneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Laune::class);
    }

    // /**
    //  * @return Laune[] Returns an array of Laune objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Laune
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
