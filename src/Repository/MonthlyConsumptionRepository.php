<?php

namespace App\Repository;

use App\Entity\MonthlyConsumption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MonthlyConsumption>
 *
 * @method MonthlyConsumption|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonthlyConsumption|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonthlyConsumption[]    findAll()
 * @method MonthlyConsumption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonthlyConsumptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonthlyConsumption::class);
    }

//    /**
//     * @return MonthlyConsumption[] Returns an array of MonthlyConsumption objects
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

//    public function findOneBySomeField($value): ?MonthlyConsumption
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
