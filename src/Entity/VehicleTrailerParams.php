<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class VehicleTrailerParams extends Vehicle
{
    #[Assert\NotBlank(message: 'Load capacity cannot be empty')]
    #[Assert\Type(type: 'integer', message: 'Load capacity must be an integer')]
    #[Assert\GreaterThan(value: 0, message: 'Load capacity must be greater than 0')]
    #[Groups(['vehicles:show'])]
    private int $loadCapacity;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Number of axles cannot be empty')]
    #[Assert\Choice(
        choices: [1, 2, 3],
        message: 'Number of axles must be one of the following: 1, 2, or 3'
    )]
    #[Assert\Type(type: 'integer', message: 'Number of axles must be an integer')]
    #[Groups(['vehicles:show'])]
    private int $numberOfAxles;


    public function getLoadCapacity(): int
    {
        return $this->loadCapacity;
    }

    public function setLoadCapacity(int $loadCapacity): void
    {
        $this->loadCapacity = $loadCapacity;
    }

    public function getNumberOfAxles(): int
    {
        return $this->numberOfAxles;
    }

    public function setNumberOfAxles(int $numberOfAxles): void
    {
        $this->numberOfAxles = $numberOfAxles;
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