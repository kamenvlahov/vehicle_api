<?php

namespace App\Service;

use App\Entity\Vehicle;
use App\Repository\FollowRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\Security;

class FollowService
{
    private Security $security;
    private FollowRepository $followRepository;

    public function __construct(Security $security, FollowRepository $followRepository)
    {
        $this->security = $security;
        $this->followRepository = $followRepository;
    }

    public function isFollowing(Vehicle $vehicle): bool
    {
        $user = $this->security->getUser();

        if (!$user) {
            return false;
        }

        return $this->followRepository->isFollowing($user, $vehicle);

    }

    public function getFollowedVehicles(?array $request): array
    {
        $user = $this->security->getUser();
        $page = $request['page'] ?? 1;
        $pageSize = $request['pageSize'] ?? 5;

        if (!$user) {
            return [];
        }
        $queryBuilder = $this->followRepository->createQueryBuilder('f')
            ->where('f.user = :user')  // Filter by user
            ->setParameter('user', $user)
            ->setFirstResult(($page - 1) * $pageSize)  // Set the offset (page number)
            ->setMaxResults($pageSize);  // Set the limit (page size)

        $query = $queryBuilder->getQuery();

        $paginator = new Paginator($query);

        return [
            'data' => $paginator->getIterator(),
            'meta' => [
                'current_page' => $page,
                'limit' => $pageSize,
                'total_items' => count($paginator),
                'total_pages' => ceil(count($paginator) / $pageSize),
            ],
        ];
    }

}