<?php

namespace App\Repository;

use App\Entity\ArticleVu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleVu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleVu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleVu[]    findAll()
 * @method ArticleVu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleVuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleVu::class);
    }

    // /**
    //  * @return ArticleVu[] Returns an array of ArticleVu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleVu
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
