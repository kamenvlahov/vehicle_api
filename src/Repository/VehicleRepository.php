<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Vehicle>
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function getAllVehicles(PaginatorInterface $paginator, Request $request, int $limit = 10)
    {
        $page = $request->query->getInt('page', 1);

        // Create a query builder to fetch all vehicles
        $query = $this->createQueryBuilder('v')
            ->getQuery();

        // Use the paginator to paginate the results
        $pagination = $paginator->paginate(
            $query, // Doctrine Query object
            $page,  // Current page number
            $limit  // Number of vehicles per page
        );

        return $pagination; // Return the pagination object
    }


}
