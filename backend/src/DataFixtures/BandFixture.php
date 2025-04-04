<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BandFixture extends Fixture
{
   public const BAND_EVENT_REFERENCE = 'band-event';

   public function load(ObjectManager $manager): void
   {
      for ($i = 1; $i <= 10; $i++) {
         $band = new Band();
         $band->setName("band{$i}");
         $band->setDescription("description{$i}");

         $manager->persist($band);
      }

      $bandEvent = new Band();
      $bandEvent->setName("bandEvent");
      $bandEvent->setDescription("descriptionBandEvent");

      $manager->persist($bandEvent);
      
      $manager->flush();

      $this->addReference(self::BAND_EVENT_REFERENCE, $bandEvent);
   }
}
