<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BandFixture extends Fixture
{
   public function load(ObjectManager $manager): void
   {
      for ($i = 1; $i <= 10; $i++) {
         $band = new Band();
         $band->setName("band{$i}");
         $band->setDescription("description{$i}");

         $manager->persist($band);
      }

      $manager->flush();
   }
}
