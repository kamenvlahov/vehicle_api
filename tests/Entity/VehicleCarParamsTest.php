<?php
// tests/Entity/VehicleCarParamsTest.php

namespace App\Tests\Entity;

use App\Entity\VehicleCarParams;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VehicleCarParamsTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testValidCarParams(): void
    {
        $car = new VehicleCarParams();
        $car->setBrand('Honda');
        $car->setModel('Civic');
        $car->setPrice(25000.50);
        $car->setQuantity(15);
        $car->setEngineCapacity(1.8);
        $car->setColor('Blue');
        $car->setNumberOfDoors(3);
        $car->setCarCategory('sedan');

        $errors = $this->validator->validate($car);
        $this->assertCount(0, $errors);
    }

    public function testInvalidEngineCapacity()
    {
        $car = new VehicleCarParams();
        $car->setBrand('Honda');
        $car->setModel('Civic');
        $car->setPrice(25000.50);
        $car->setQuantity(15);
        $car->setEngineCapacity(0);  // Setting it to 0 to trigger the error
        $car->setColor('Blue');
        $car->setNumberOfDoors(3);
        $car->setCarCategory('sedan');

        $errors = $this->validator->validate($car);

        $this->assertCount(1, $errors);
        $this->assertSame('Engine capacity should be greater than zero', $errors[0]->getMessage());
    }

    public function testInvalidColour(): void
    {
        $car = new VehicleCarParams();
        $car->setBrand('Honda');
        $car->setModel('Civic');
        $car->setPrice(25000.50);
        $car->setQuantity(15);
        $car->setEngineCapacity(1.8);
        $car->setColor('');
        $car->setNumberOfDoors(3);
        $car->setCarCategory('sedan');

        $errors = $this->validator->validate($car);
        $this->assertGreaterThan(0, $errors);
        $this->assertSame('Color cannot be empty', $errors[0]->getMessage());
    }
}
