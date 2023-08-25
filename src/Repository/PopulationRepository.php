<?php

namespace App\Repository;

use App\Entity\Population;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Population>
 *
 * @method Population|null find($id, $lockMode = null, $lockVersion = null)
 * @method Population|null findOneBy(array $criteria, array $orderBy = null)
 * @method Population[]    findAll()
 * @method Population[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PopulationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Population::class);
    }

    //    /**
    //     * @return Population[] Returns an array of Population objects
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

    //    public function findOneBySomeField($value): ?Population
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
