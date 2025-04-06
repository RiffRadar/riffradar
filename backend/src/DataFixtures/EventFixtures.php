<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Bar;
use App\Entity\Band;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Enum\StatusEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
   public function load(ObjectManager $manager): void
   {
      $event = new Event();
      $event->setBar($this->getReference(BarFixture::BAR_EVENT_REFERENCE, Bar::class));
      $event->setBand($this->getReference(BandFixture::BAND_EVENT_REFERENCE, Band::class));
      $event->setDateTime(new DateTime('now'));
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
