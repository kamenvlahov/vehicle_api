<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Serializer\VehicleSerializerEncoder;
use App\Serializer\VehicleShowSerializerEncoder;
use App\Service\VehicleService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Validator\ValidatorInterface;

#[Route('/api/vehicle')]
class VehicleController extends AbstractController
{
    private VehicleSerializerEncoder $vehicleSerializer;
    private VehicleShowSerializerEncoder $showSerializerEncoder;
    private VehicleService $vehicleService;

    public function __construct(
        VehicleSerializerEncoder     $vehicleSerializer,
        VehicleService               $vehicleService,
        VehicleShowSerializerEncoder $showSerializerEncoder

    )
    {
        $this->vehicleSerializer = $vehicleSerializer;
        $this->vehicleService = $vehicleService;
        $this->showSerializerEncoder = $showSerializerEncoder;
    }

    #[Route('/', name: 'api_vehicle_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $data = $this->vehicleService->getVehicles($request->query->all(), $this->getUser());
        return new JsonResponse($this->vehicleSerializer->serialize($data, 'json'), JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'api_vehicle_show', methods: ['GET'])]
    public function show(Vehicle $vehicle)
    {
        $data = $this->vehicleService->getVehicleById($vehicle);

        if (!$data) {
            return new JsonResponse(['message' => 'Vehicle not found'], 404);
        }

        return new JsonResponse($this->showSerializerEncoder->serialize($data, 'json'), JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/', name: 'api_vehicle_new', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $vehicle = $this->vehicleService->createVehicle($data);
            $validator->validate($vehicle);
            $this->vehicleService->save($vehicle);

            return new JsonResponse("Vehicle created successfully with ID: " . $vehicle->getId(), Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {

            return new JsonResponse("Error: " . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'Car created successfully!'], 200);
    }

}
