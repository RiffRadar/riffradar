<?php

namespace App\DataFixtures;

use App\Entity\Bar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BarFixture extends Fixture
{
   public function load(ObjectManager $manager): void
   {
      for ($i = 1; $i <= 10; $i++) {
         $bar = new Bar();
         $bar->setName("bar{$i}");
         $bar->setDescription("description{$i}");
         $bar->setAddress("address{$i}");
         $bar->setPostalCode("PostalCode{$i}");
         $bar->setCity("city{$i}");
         $bar->setTelephone("telephone{$i}");

         $manager->persist($bar);
      }

      $manager->flush();
   }
}
