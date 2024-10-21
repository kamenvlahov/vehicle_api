<?php

namespace App\Tests\Service;

use App\Entity\Vehicle;
use App\Entity\VehicleCarParams;
use App\Factory\VehicleParamsFactory;
use App\Service\VehicleService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use PHPUnit\Framework\TestCase;
use App\Serializer\VehicleSerializerEncoder;
use Symfony\Component\Serializer\SerializerInterface;


class VehicleServiceTest extends TestCase
{
    private VehicleParamsFactory $vehicleFactory;
    private EntityManagerInterface $entityManager;
    private EntityRepository $vehicleRepository;
    private VehicleSerializerEncoder $vehicleSerializer;
    private SerializerInterface $serializer;
    private VehicleService $vehicleService;

    protected function setUp(): void
    {
        $this->vehicleFactory = $this->createMock(VehicleParamsFactory::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->vehicleRepository = $this->createMock(EntityRepository::class);
        $this->vehicleSerializer = $this->createMock(VehicleSerializerEncoder::class);
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->entityManager->method('getRepository')->willReturn($this->vehicleRepository);

        $this->vehicleService = new VehicleService(
            $this->vehicleFactory,
            $this->entityManager,
            $this->vehicleSerializer,
            $this->serializer
        );
    }

    public function testCreateVehicle(): void
    {
        $vehicleData = [
            'type' => 'car',
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'price' => 20000,
            'color' => 'Red',
            'engineCapacity' => 1.5,
            'numberOfDoors' => 4,
            'carCategory' => 'sedan',
        ];

        $vehicleMock = $this->createMock(Vehicle::class);

        $this->vehicleFactory->expects($this->once())
            ->method('createVehicle')
            ->with('car')
            ->willReturn($vehicleMock);

        $vehicleMock->expects($this->once())
            ->method('setBrand')
            ->with('Toyota');
        $vehicleMock->expects($this->once())
            ->method('setModel')
            ->with('Corolla');
        $vehicleMock->expects($this->once())
            ->method('setPrice')
            ->with(20000);

        $this->vehicleService->createVehicle($vehicleData);
    }



    public function testSaveVehicle(): void
    {
        $vehicleMock = $this->createMock(Vehicle::class);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($vehicleMock);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->vehicleService->save($vehicleMock);
    }

    public function testGetVehicleById(): void
    {
        $vehicleMock = $this->createMock(Vehicle::class);
        $vehicleMock->method('getType')->willReturn('car');
        $this->vehicleRepository->method('find')->willReturn($vehicleMock);

        $result = $this->vehicleService->getVehicleById($vehicleMock);

        $this->assertEquals('car', $result['type']);
        $this->assertSame($vehicleMock, $result['data']);
    }

    private function createQueryBuilderMock(array $vehicles)
    {
        $queryBuilderMock = $this->getMockBuilder(\Doctrine\ORM\QueryBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setFirstResult', 'setMaxResults', 'getQuery'])
            ->getMock();

        $queryBuilderMock->method('setFirstResult')->willReturn($queryBuilderMock);
        $queryBuilderMock->method('setMaxResults')->willReturn($queryBuilderMock);


        $queryMock = $this->getMockBuilder(\Doctrine\ORM\Query::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['execute', 'getArrayResult'])
            ->getMock();


        $queryMock->method('execute')->willReturn($vehicles);


        $queryMock->method('getArrayResult')->willReturn($vehicles);


        $queryBuilderMock->method('getQuery')->willReturn($queryMock);

        return $queryBuilderMock;
    }
}
