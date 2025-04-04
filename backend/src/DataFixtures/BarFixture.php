<?php

namespace App\DataFixtures;

use App\Entity\Bar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BarFixture extends Fixture
{
   public const BAR_EVENT_REFERENCE = 'bar-event';

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

      $barEvent = new Bar();
      $barEvent->setName("barEvent");
      $barEvent->setDescription("descriptionBarEvent");
      $barEvent->setAddress("addressEvent");
      $barEvent->setPostalCode("PostalCodeEvent");
      $barEvent->setCity("cityEvent");
      $barEvent->setTelephone("telephoneEvent");

      $manager->persist($barEvent);

      $manager->flush();

      $this->addReference(self::BAR_EVENT_REFERENCE, $barEvent);
   }
}
