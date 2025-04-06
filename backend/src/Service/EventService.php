<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\BandRepository;
use App\Repository\BarRepository;
use App\Enum\StatusEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\DataTransferObject\CreateEventDTO;
use Exception;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

readonly class EventService
{
   public function __construct(
      private EntityManagerInterface $entityManager,
      private BarRepository $barRepository,
      private BandRepository $bandRepository,
      private SerializerInterface $serializer
   ) {}

   public function createEvent(CreateEventDTO $createEventDTO): JsonResponse
   {
      $bar = $this->barRepository->findOneBy(['id' => $createEventDTO->barId]);

      if (!$bar) {
         return new JsonResponse(['error' => 'bar not found'], 404);
      }

      $band = $this->bandRepository->findOneBy(['id' => $createEventDTO->bandId]);

      if (!$band) {
          return new JsonResponse(['error' => 'band not found'], 404);
      }

      try {
         $event = new Event();
         $event->setBar($bar);
         $event->setBand($band);
         $event->setDateTime($createEventDTO->dateTime);
         $event->setStatus(StatusEnum::pending);

         $this->entityManager->persist($event);
         $this->entityManager->flush();

         $jsonContent = $this->serializer->serialize($event, 'json');

          return JsonResponse::fromJsonString($jsonContent, 201);
      } catch (Exception $exception) {
          return new JsonResponse(['error' => $exception->getMessage()], 500);
      }
   }
}
