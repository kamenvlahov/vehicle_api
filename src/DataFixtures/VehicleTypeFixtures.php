<?php

namespace App\DataFixtures;

use App\Entity\VehicleType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $vehicleTypes = [ 'motorcycle', 'car', 'truck', 'trailer'];

        foreach ($vehicleTypes as $type) {
            $vehicle = new VehicleType();
            $vehicle->setName($type);
            $manager->persist($vehicle);
        }

        $manager->flush();
    }
}
