<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
   public function testCreation(): void
   {
      $user = new User();
      $this->assertInstanceOf(User::class, $user);
   }

   public function testEmail(): void
   {
      $user = new User();
      $user->setEmail('test@example.com');
      $this->assertEquals('test@example.com', $user->getEmail());
   }

   public function testPassword(): void
   {
      $user = new User();
      $user->setPassword('password');
      $this->assertEquals('password', $user->getPassword());
   }

   public function testFirstname(): void
   {
      $user = new User();
      $user->setFirstname('firstname');
      $this->assertEquals('firstname', $user->getFirstname());
   }

   public function testLastname(): void
   {
      $user = new User();
      $user->setLastname('lastname');
      $this->assertEquals('lastname', $user->getLastname());
   }
}
