<?php

namespace App\Controller;

use App\Entity\Follow;
use App\Repository\FollowRepository;
use App\Repository\VehicleRepository;
use App\Serializer\FollowSerializerEncoder;
use App\Service\FollowService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api/follow')]
class FollowController extends AbstractController
{
    private $security;
    private FollowSerializerEncoder $vehicleSerializer;
    private $followService;

    public function __construct(Security $security, FollowSerializerEncoder $vehicleSerializer, FollowService $followService)
    {
        $this->security = $security;
        $this->vehicleSerializer = $vehicleSerializer;
        $this->followService = $followService;
    }

    #[Route('/', name: 'api_followed_vehicles', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $follows = $this->followService->getFollowedVehicles($request->query->all());
        return new JsonResponse($this->vehicleSerializer->serialize($follows, 'json'), JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{vehicleId}', name: 'api_follow_vehicle', methods: ['POST'])]
    public function add(int $vehicleId, VehicleRepository $vehicleRepository, EntityManagerInterface $em): JsonResponse
    {
        $vehicle = $vehicleRepository->find($vehicleId);
        if (!$vehicle) {
            return new JsonResponse(['error' => 'Vehicle not found'], Response::HTTP_NOT_FOUND);
        }

        $user = $this->getUser();

        foreach ($user->getFollows() as $follow) {
            if ($follow->getVehicle()->getId() === $vehicle->getId()) {
                return new JsonResponse(['message' => 'Already following'], Response::HTTP_CONFLICT);
            }
        }

        $follow = new Follow();
        $follow->setUser($user);
        $follow->setVehicle($vehicle);

        $em->persist($follow);
        $em->flush();

        return new JsonResponse(['message' => 'Vehicle followed successfully'], Response::HTTP_OK);
    }

    #[Route('/unfollow/{vehicleId}', name: 'api_unfollow_vehicle', methods: ['DELETE'])]
    public function unfollowVehicle(int $vehicleId, FollowRepository $followRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();

        $follow = $followRepository->findOneBy(['user' => $user, 'vehicle' => $vehicleId]);
        if (!$follow) {
            return new JsonResponse(['error' => 'Follow not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($follow);
        $em->flush();

        return new JsonResponse(['message' => 'Vehicle unfollowed successfully'], Response::HTTP_OK);
    }
}
