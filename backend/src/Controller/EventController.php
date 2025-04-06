<?php

namespace App\Controller;

use App\DataTransferObject\CreateEventDTO;
use App\Enum\StatusEnum;
use App\Repository\EventRepository;
use App\Service\EventService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/event')]
final class EventController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly EventRepository        $eventRepository,
        private readonly ValidatorInterface     $validator,
        private readonly SerializerInterface    $serializer,
        private readonly EventService           $eventService

    )
    {
    }

    #[Route('/new', name: 'event_new', methods: ['POST'], format: 'json')]
    public function new(Request $request): JsonResponse
    {
        $jsonData = $request->getContent();

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $eventDTO = $this->serializer->deserialize($jsonData, CreateEventDTO::class, 'json');

            $error = $this->validator->validate($eventDTO);

            if (count($error) > 0) {
                return $this->json($error, 422);
            }

            return $this->eventService->createEvent($eventDTO);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'event_list', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $events = $this->eventRepository->findAll();

        try {
            return $this->json($events, 200);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/open_events', name: 'event_open', methods: ['GET'], format: 'json')]
    public function getOpenEvents(): JsonResponse
    {
        $events = $this->eventRepository->findOpenAndValidated();

        try {
            return $this->json($events, 200);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'event_show', methods: ['GET'], format: 'json')]
    public function show(int $id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        if (!$event) {
            return $this->json(['error' => 'Event not found'], 404);
        }

        try {
            return $this->json($event, 200);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}/{status}', name: 'event_accept', methods: ['PUT'], format: 'json')]
    public function status(int $id, string $status): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        if (!$event) {
            return $this->json(['error' => 'Event not found'], 404);
        }

        $statusEnum = StatusEnum::tryFrom($status);

        if (!$statusEnum) {
            return $this->json(['error' => 'Invalid status'], 400);
        }

        try {
            $event->setStatus($statusEnum);

            $this->entityManager->persist($event);
            $this->entityManager->flush();

            return $this->json($event, 202);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
