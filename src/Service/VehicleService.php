<?php

namespace App\Service;


use AllowDynamicProperties;
use App\Entity\Vehicle;
use App\Factory\VehicleParamsFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Serializer\VehicleSerializerEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AllowDynamicProperties] class VehicleService
{
    private VehicleParamsFactory $vehicleFactory;
    private EntityManagerInterface $entityManager;


    public function __construct(VehicleParamsFactory     $vehicleFactory,
                                EntityManagerInterface   $entityManager,
                                VehicleSerializerEncoder $vehicleSerializer,
                                SerializerInterface      $serializer,

    )
    {
        $this->vehicleFactory = $vehicleFactory;
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $this->serializer = $serializer;
    }

    public function createVehicle(array $vehicleData): Vehicle|null
    {
        $vehicle = $this->vehicleFactory->createVehicle($vehicleData['type']);
        $this->deserializeVehicleData($vehicle, $vehicleData);

        return $vehicle;
    }

    public function updateVehicle(Vehicle $vehicle, $data): Vehicle
    {
        $data = json_decode($data, true);
        $this->deserializeVehicleData($vehicle, $data);

        return $vehicle;
    }

    public function save(Vehicle $vehicle): void
    {
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }

    private function deserializeVehicleData(Vehicle $vehicle, array $vehicleData): void
    {
        foreach ($vehicleData as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($vehicle, $method)) {
                $vehicle->$method($value);
            }
        }
    }

    public function getVehicles(?array $request): array
    {
        $page = $request['page'] ?? 1;
        $pageSize = $request['pageSize'] ?? 5;
        $query = $this->vehicleRepository->createQueryBuilder('v')
            ->setFirstResult(($page - 1) * $pageSize) // Offset
            ->setMaxResults($pageSize) // Limit
            ->getQuery();

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

    public function getVehicleById(Vehicle $vehicle): array
    {
        $vehicle = $this->vehicleRepository->find($vehicle);
        return ['type' => $vehicle->getType(), 'data' => $vehicle];
    }
}