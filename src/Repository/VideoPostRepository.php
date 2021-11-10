<?php

namespace App\Repository;

use App\Entity\VideoPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoPost[]    findAll()
 * @method VideoPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoPost::class);
    }

    // /**
    //  * @return VideoPost[] Returns an array of VideoPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoPost
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
