<?php
// src/Entity/Vehicle.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['motorcycle' => VehicleMotorcycleParams::class, 'car' => VehicleCarParams::class, 'truck' => VehicleTruckParams::class, 'trailer' => VehicleTrailerParams::class])]
abstract class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vehicles:read', 'vehicles:show', 'follow:read'])]
    private int $id;

    #[ORM\Column(length: 255)]
    #[Groups(['vehicles:read', 'vehicles:show', 'follow:read'])]
    #[Assert\NotBlank(message: 'Brand should not be empty')]
    #[Assert\Type('string', message: 'Brand should be a string')]
    private string $brand;

    #[ORM\Column(length: 255)]
    #[Groups(['vehicles:read', 'vehicles:show', 'follow:read'])]
    #[Assert\NotBlank(message: 'Model should not be empty')]
    #[Assert\Type('string', message: 'Model should be a string')]
    private string $model;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['vehicles:read', 'vehicles:show', 'follow:read'])]
    #[Assert\NotBlank(message: 'Price should not be empty')]
    #[Assert\Type(type: 'numeric', message: 'Price should be a number')]
    #[Assert\Positive(message: 'Price should be greater than zero')]
    private float $price;

    #[ORM\Column(type: 'integer')]
    #[Groups(['vehicles:read', 'vehicles:show', 'follow:read'])]
    #[Assert\Type(type: 'integer', message: 'Quantity should be an integer')]
    #[Assert\PositiveOrZero(message: 'Quantity should be a positive integer')]
    private int $quantity;

    public function getId(): int
    {
        return $this->id;
    }
    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getType(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }


}



