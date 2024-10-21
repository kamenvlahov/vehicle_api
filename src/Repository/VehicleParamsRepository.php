<?php

namespace App\Repository;

use App\Entity\VehicleParams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleParams>
 *
 * @method VehicleParams|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleParams|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleParams[]    findAll()
 * @method VehicleParams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleParamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleParams::class);
    }

//    /**
//     * @return VehicleParams[] Returns an array of VehicleParams objects
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

//    public function findOneBySomeField($value): ?VehicleParams
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
