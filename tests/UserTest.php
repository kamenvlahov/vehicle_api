<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testEmail(): void
    {
        $user = new User();
        $email = 'test@example.com';

        // Set the email and assert it's correctly returned
        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($email, $user->getUserIdentifier());
    }

    public function testPassword(): void
    {
        $user = new User();
        $password = 'hashed_password';

        // Set the password and assert it's correctly returned
        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
    }

    public function testRoles(): void
    {
        $user = new User();
        $roles = ['ROLE_ADMIN'];

        // Set the roles and assert the default role is always included
        $user->setRoles($roles);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testEraseCredentials(): void
    {
        $user = new User();

        // Normally, eraseCredentials would clear sensitive data like plain passwords
        // Since there's no sensitive data stored, we just call it to ensure no error occurs
        $user->eraseCredentials();

        // Assert no side effects or exceptions
        $this->assertTrue(true);
    }

    public function testGetId(): void
    {
        $user = new User();

        // Normally, the ID is set by the database, but for testing, we can simulate it using reflection
        $reflection = new \ReflectionClass(User::class);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($user, 1);

        // Assert that the ID is set correctly
        $this->assertEquals(1, $user->getId());
    }
}
