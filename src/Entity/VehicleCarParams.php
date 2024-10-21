<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity()]
class VehicleCarParams extends Vehicle
{
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Number of doors cannot be empty')]
    #[Assert\Range(notInRangeMessage: 'Number of doors must be between 3 and 5', min: 3, max: 5)]
    #[Groups(['vehicles:show'])]
    private int $numberOfDoors;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Car category cannot be empty')]
    #[Assert\Choice(choices: ['sedan', 'hatchback', 'suv', 'coupe', 'convertible'], message: 'Invalid car category')]
    #[Groups(['vehicles:show'])]
    private string $carCategory;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    #[Assert\NotBlank(message: 'Engine capacity cannot be empty')]
    #[Assert\Type(type: 'numeric', message: 'Engine capacity must be a number')]
    #[Assert\GreaterThan(value: 0, message: 'Engine capacity should be greater than zero')]
    #[Groups(['vehicles:show'])]
    private float $engineCapacity;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Color cannot be empty')]
    #[Assert\Type(type: 'string', message: 'Color must be a valid string')]
    #[Groups(['vehicles:show'])]
    private string $color;

    public function getNumberOfDoors(): int
    {
        return $this->numberOfDoors;
    }

    public function setNumberOfDoors(int $numberOfDoors): static
    {
        $this->numberOfDoors = $numberOfDoors;
        return $this;
    }

    public function getCarCategory(): string
    {
        return $this->carCategory;
    }

    public function setCarCategory(string $carCategory): void
    {
        $this->carCategory = $carCategory;
    }

    public function getEngineCapacity(): float
    {
        return $this->engineCapacity;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setEngineCapacity(float $engineCapacity): void
    {
        $this->engineCapacity = $engineCapacity;
    }
    public function isFollowedByUser(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        foreach ($this->getFollows() as $follow) {
            if ($follow->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}
