<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
   private UserPasswordHasherInterface $userPassword;
   public function __construct(UserPasswordHasherInterface $userPassword)
   {
      $this->userPassword = $userPassword;
   }

   public function load(ObjectManager $manager): void
   {
      for ($i = 1; $i <= 10; $i++) {
         $user = new User();
         $user->setEmail("user{$i}@example.com");
         $user->setPassword($this->userPassword->hashPassword($user, "password{$i}"));
         $user->setFirstname("firstname{$i}");
         $user->setLastname("lastname{$i}");

         $manager->persist($user);
      }

      $manager->flush();
   }
}
