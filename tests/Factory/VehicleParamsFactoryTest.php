<?php

namespace App\Tests\Factory;

use App\Factory\VehicleParamsFactory;
use App\Entity\VehicleCarParams;
use App\Entity\VehicleMotorcycleParams;
use App\Entity\VehicleTruckParams;
use App\Entity\VehicleTrailerParams;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class VehicleParamsFactoryTest extends TestCase
{
    private VehicleParamsFactory $vehicleParamsFactory;

    protected function setUp(): void
    {
        $this->vehicleParamsFactory = new VehicleParamsFactory();
    }

    public function testCreateCarVehicle(): void
    {
        $vehicle = $this->vehicleParamsFactory->createVehicle('car');

        $this->assertInstanceOf(VehicleCarParams::class, $vehicle);
    }

    public function testCreateMotorcycleVehicle(): void
    {
        $vehicle = $this->vehicleParamsFactory->createVehicle('motorcycle');

        $this->assertInstanceOf(VehicleMotorcycleParams::class, $vehicle);
    }

    public function testCreateTruckVehicle(): void
    {
        $vehicle = $this->vehicleParamsFactory->createVehicle('truck');

        $this->assertInstanceOf(VehicleTruckParams::class, $vehicle);
    }

    public function testCreateTrailerVehicle(): void
    {
        $vehicle = $this->vehicleParamsFactory->createVehicle('trailer');

        $this->assertInstanceOf(VehicleTrailerParams::class, $vehicle);
    }

    public function testCreateUnknownVehicle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown vehicle type: spaceship'); // Adjust this to the type you're testing

        $this->vehicleParamsFactory->createVehicle('spaceship');
    }
}
