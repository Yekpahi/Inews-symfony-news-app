<?php

namespace App\Repository;

use App\Entity\ImageALaUne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageALaUne|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageALaUne|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageALaUne[]    findAll()
 * @method ImageALaUne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageALaUneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageALaUne::class);
    }

    // /**
    //  * @return ImageALaUne[] Returns an array of ImageALaUne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageALaUne
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
