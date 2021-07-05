<?php

namespace App\Repository;

use App\Entity\MessageVu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageVu|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageVu|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageVu[]    findAll()
 * @method MessageVu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageVuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageVu::class);
    }

    // /**
    //  * @return MessageVu[] Returns an array of MessageVu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageVu
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
