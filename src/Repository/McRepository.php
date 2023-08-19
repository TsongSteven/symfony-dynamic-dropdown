<?php

namespace App\Repository;

use App\Entity\Mc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mc>
 *
 * @method Mc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mc[]    findAll()
 * @method Mc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class McRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mc::class);
    }

    //    /**
    //     * @return Mc[] Returns an array of Mc objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Mc
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
