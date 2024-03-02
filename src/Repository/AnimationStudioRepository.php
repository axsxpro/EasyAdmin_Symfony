<?php

namespace App\Repository;

use App\Entity\AnimationStudio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimationStudio>
 *
 * @method AnimationStudio|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimationStudio|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimationStudio[]    findAll()
 * @method AnimationStudio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimationStudioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimationStudio::class);
    }

    //    /**
    //     * @return AnimationStudio[] Returns an array of AnimationStudio objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AnimationStudio
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
