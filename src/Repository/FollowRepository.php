<?php

namespace App\Repository;

use App\Entity\Follow;
use App\Entity\User;
use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Follow>
 *
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    public function isFollowing(User $user, Vehicle $vehicle): bool
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.user = :user')
            ->andWhere('f.vehicle = :vehicle')
            ->setParameter('user', $user)
            ->setParameter('vehicle', $vehicle);

        return (bool) $qb->getQuery()->getOneOrNullResult() !== null;
    }


}
