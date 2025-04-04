<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Bar;
use App\Entity\Band;
use App\DataFixtures\BarFixture;
use App\DataFixtures\BandFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Enum\StatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
   public function load(ObjectManager $manager): void
   {
      $event = new Event();
      $event->setBarid($this->getReference(BarFixture::BAR_EVENT_REFERENCE, Bar::class));
      $event->setBandid($this->getReference(BandFixture::BAND_EVENT_REFERENCE, Band::class));
      $event->setDate(new \DateTime("now"));
      $event->setTime(new \DateTime("now"));
      $event->setStatus(StatusEnum::pending);

      $manager->persist($event);

      $manager->flush();
   }

   public function getDependencies(): array
    {
        return [
            BarFixture::class,
            BandFixture::class
        ];
    }
}
