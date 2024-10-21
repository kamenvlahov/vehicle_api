<?php

namespace App\Factory;

use App\Entity\VehicleCarParams;
use App\Entity\VehicleMotorcycleParams;
use App\Entity\VehicleTruckParams;
use App\Entity\VehicleTrailerParams;
use App\Entity\Vehicle;

class VehicleParamsFactory
{
    /**
     * @param string $type
     * @return Vehicle
     */
    public function createVehicle(string $type): Vehicle
    {
        return match ($type) {
            'motorcycle' => new VehicleMotorcycleParams(),
            'car' => new VehicleCarParams(),
            'truck' => new VehicleTruckParams(),
            'trailer' => new VehicleTrailerParams(),
            default => throw new \InvalidArgumentException("Unknown vehicle type: $type"),
        };
    }
}