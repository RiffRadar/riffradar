<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\BandRepository;
use App\Repository\BarRepository;
use App\Enum\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\DataTransferObject\CreateEventDTO;
use Exception;

readonly class EventService
{
   public function __construct(
      private EntityManagerInterface $entityManager,
      private BarRepository $barRepository,
      private BandRepository $bandRepository,
   ) {}

   public function createEvent(CreateEventDTO $createEventDTO): array
   {
      $bar = $this->barRepository->findOneBy(['id' => $createEventDTO->barId]);

      if (!$bar) {
         return ['error' => 'Bar not found', 'status' => '404'];
      }

      $band = $this->bandRepository->findOneBy(['id' => $createEventDTO->bandId]);

      if (!$band) {
         return ['error' => 'Band not found', 'status' => '404'];
      }

      try {
         $event = new Event();
         $event->setBarId($bar);
         $event->setBandId($band);
         $event->setDateTime($createEventDTO->dateTime);
         $event->setStatus(StatusEnum::pending);

         $this->entityManager->persist($event);
         $this->entityManager->flush();

         return [$event, 'status' => 201];
      } catch (Exception $exception) {
         return ['error' => $exception->getMessage(), 'status' => 500];
      }
   }
}
