<?php

namespace App\Tests\Entity;

use App\Entity\Follow;
use App\Entity\User;
use App\Entity\VehicleCarParams;
use PHPUnit\Framework\TestCase;

class FollowTest extends TestCase
{
    public function testFollowInitialization()
    {
        $follow = new Follow();

        // Assert that the Follow entity is instantiated correctly
        $this->assertInstanceOf(Follow::class, $follow);
        $this->assertNull($follow->getId());
        $this->assertNull($follow->getVehicle());
    }

    public function testSetUser()
    {
        $user = new User(); // Create a User entity
        $follow = new Follow();

        // Set the user and check if it is set correctly
        $follow->setUser($user);
    }

    public function testSetVehicle()
    {
        $vehicle = new VehicleCarParams(); // Create a Vehicle entity
        $follow = new Follow();

        // Set the vehicle and check if it is set correctly
        $follow->setVehicle($vehicle);
        $this->assertSame($vehicle, $follow->getVehicle());
    }

    public function testSetUserAndVehicle()
    {
        $user = new User();
        $vehicle = new VehicleCarParams();
        $follow = new Follow();

        // Set both user and vehicle
        $follow->setUser($user);
        $follow->setVehicle($vehicle);

        // Assertions to check the relationships
        $this->assertSame($vehicle, $follow->getVehicle());
    }
}
