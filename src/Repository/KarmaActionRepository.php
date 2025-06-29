<?php

namespace App\Repository;

use App\Entity\KarmaAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KarmaAction>
 */
class KarmaActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KarmaAction::class);
    }

    //    /**
    //     * @return KarmaAction[] Returns an array of KarmaAction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('k.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?KarmaAction
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
