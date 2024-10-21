<?php

namespace App\Tests\Service;

use App\Entity\User; // Your User entity that implements UserInterface
use App\Entity\Vehicle; // Assuming this is your abstract Vehicle class
use App\Repository\FollowRepository;
use App\Service\FollowService;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Security;

class FollowServiceTest extends TestCase
{
    private FollowService $followService;
    private MockObject $security;
    private MockObject $followRepository;
    private User $user; // This will be a real User instance
    private MockObject $mockedVehicle;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->followRepository = $this->createMock(FollowRepository::class);

        // Create a real User instance, ensure it matches your User entity structure
        $this->user = new User(); // You might want to set any required properties here

        $this->followService = new FollowService($this->security, $this->followRepository);
        $this->mockedVehicle = $this->createMock(Vehicle::class); // Mock Vehicle since it's abstract
    }

    public function testIsFollowingUserIsNull(): void
    {
        $this->security->method('getUser')->willReturn(null);

        $this->assertFalse($this->followService->isFollowing($this->mockedVehicle));
    }

    public function testIsFollowingUserIsFollowing(): void
    {
        $this->security->method('getUser')->willReturn($this->user);
        $this->followRepository->method('isFollowing')->with($this->user, $this->mockedVehicle)->willReturn(true);

        $this->assertTrue($this->followService->isFollowing($this->mockedVehicle));
    }

    public function testIsFollowingUserIsNotFollowing(): void
    {
        $this->security->method('getUser')->willReturn($this->user);
        $this->followRepository->method('isFollowing')->with($this->user, $this->mockedVehicle)->willReturn(false);

        $this->assertFalse($this->followService->isFollowing($this->mockedVehicle));
    }

    public function testGetFollowedVehiclesNoUser(): void
    {
        $this->security->method('getUser')->willReturn(null);

        $result = $this->followService->getFollowedVehicles([]);

        $this->assertSame([], $result);
    }

}
