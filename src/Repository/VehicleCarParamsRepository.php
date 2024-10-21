<?php

namespace App\Repository;

use App\Entity\VehicleCarParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleCarParams>
 *
 * @method VehicleCarParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleCarParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleCarParams[]    findAll()
 * @method VehicleCarParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleCarParamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleCarParams::class);
    }

//    /**
//     * @return VehicleCarParams[] Returns an array of VehicleCarParams objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VehicleCarParams
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
