<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class VehicleMotorcycleParams extends Vehicle
{
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    #[Assert\NotBlank(message: 'Engine capacity cannot be empty')]
    #[Assert\Type(type: 'numeric', message: 'Engine capacity must be a number (integer or decimal)')]
    #[Assert\GreaterThan(value: 0, message: 'Engine capacity must be greater than 0')]
    #[Groups(['vehicles:show'])]
    private float $engineCapacity;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Color cannot be empty')]
    #[Assert\Type(type: 'string', message: 'Color must be a valid string')]
    #[Groups(['vehicles:show'])]
    private string $color;

    public function getEngineCapacity(): float
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(float $engineCapacity): void
    {
        $this->engineCapacity = $engineCapacity;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
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