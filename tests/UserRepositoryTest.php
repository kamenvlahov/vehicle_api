<?php
namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class UserRepositoryTest extends KernelTestCase
{
    private ?UserRepository $userRepository = null;
    private ?EntityManagerInterface $entityManager = null;

    // Boot the Symfony kernel before each test
    protected function setUp(): void
    {
        self::bootKernel();

        // Get the entity manager and the user repository from the container
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->userRepository = self::getContainer()->get(UserRepository::class);

        // Clear the database to ensure the tests run with a clean state
        $this->clearDatabase();
    }

    // Clear the database before each test (to avoid duplicate entries)
    private function clearDatabase(): void
    {
        $connection = $this->entityManager->getConnection();
        $connection->beginTransaction();
        $this->entityManager->createQuery('DELETE FROM App\Entity\User')->execute();
        $connection->commit();
    }

    // Test the "create user" functionality
    public function testCreateUser(): void
    {
        // Create a new user instance
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('hashed_password'); // Add proper password hashing logic if needed
        $user->setRoles(['ROLE_USER']);

        // Save the user to the database using the EntityManager
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Query the user back by email
        $savedUser = $this->userRepository->findOneByEmail('test@example.com');

        // Assert that the user was saved
        $this->assertNotNull($savedUser);
        $this->assertSame('test@example.com', $savedUser->getEmail());
    }

    // Test the "find one by email" method of the repository
    public function testFindOneByEmail(): void
    {
        // Create a new user instance and save it
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('hashed_password');
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Query the user by email
        $foundUser = $this->userRepository->findOneByEmail('test@example.com');

        // Assert that the user exists and the email matches
        $this->assertNotNull($foundUser);
        $this->assertSame('test@example.com', $foundUser->getEmail());
    }
}

