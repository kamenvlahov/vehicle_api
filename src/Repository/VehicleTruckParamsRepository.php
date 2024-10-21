<?php

namespace App\Repository;

use App\Entity\VehicleTruckParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleTruckParams>
 *
 * @method VehicleTruckParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleTruckParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleTruckParams[]    findAll()
 * @method VehicleTruckParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleTruckParamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleTruckParams::class);
    }

//    /**
//     * @return VehicleTruckParams[] Returns an array of VehicleTruckParams objects
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

//    public function findOneBySomeField($value): ?VehicleTruckParams
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
