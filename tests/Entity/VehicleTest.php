<?php
// tests/Entity/VehicleTest.php

namespace App\Tests\Entity;

use App\Entity\VehicleCarParams;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VehicleTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testValidVehicle(): void
    {
        $vehicle = new VehicleCarParams();
        $vehicle->setBrand('Toyota');
        $vehicle->setModel('Camry');
        $vehicle->setPrice(30000.99);
        $vehicle->setQuantity(10);
        $vehicle->setEngineCapacity(2.5);
        $vehicle->setColor('Red');
        $vehicle->setNumberOfDoors(4);
        $vehicle->setCarCategory('sedan');

        $errors = $this->validator->validate($vehicle);
        $this->assertCount(0, $errors); // No validation errors
    }

    public function testInvalidBrand(): void
    {
        $vehicle = new VehicleCarParams();
        $vehicle->setBrand('');
        $vehicle->setModel('Camry');
        $vehicle->setPrice(30000.99);
        $vehicle->setQuantity(10);
        $vehicle->setEngineCapacity(2.5);
        $vehicle->setColor('Red');
        $vehicle->setNumberOfDoors(4);
        $vehicle->setCarCategory('sedan');

        $errors = $this->validator->validate($vehicle);
        $this->assertGreaterThan(0, $errors);
        $this->assertSame('Brand should not be empty', $errors[0]->getMessage());
    }

    public function testInvalidPrice(): void
    {
        $vehicle = new VehicleCarParams();
        $vehicle->setBrand('Toyota');
        $vehicle->setModel('Camry');
        $vehicle->setPrice(-100);
        $vehicle->setQuantity(10);
        $vehicle->setEngineCapacity(2.5);
        $vehicle->setColor('Red');
        $vehicle->setNumberOfDoors(4);
        $vehicle->setCarCategory('sedan');

        $errors = $this->validator->validate($vehicle);
        $this->assertGreaterThan(0, $errors);
        $this->assertSame('Price should be greater than zero', $errors[0]->getMessage());
    }

    public function testInvalidQuantity(): void
    {
        $vehicle = new VehicleCarParams();
        $vehicle->setBrand('Toyota');
        $vehicle->setModel('Camry');
        $vehicle->setPrice(30000.99);
        $vehicle->setQuantity(-5);
        $vehicle->setEngineCapacity(2.5);
        $vehicle->setColor('Red');
        $vehicle->setNumberOfDoors(4);
        $vehicle->setCarCategory('sedan');

        $errors = $this->validator->validate($vehicle);
        $this->assertGreaterThan(0, $errors);
        $this->assertSame('Quantity should be a positive integer', $errors[0]->getMessage());
    }
}
