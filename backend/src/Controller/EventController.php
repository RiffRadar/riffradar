<?php

namespace App\Controller;

use Composer\XdebugHandler\Status;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Enum\StatusEnum;

#[Route('/api/event')]
final class EventController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private EventRepository $eventRepository,
        private ValidatorInterface $validator
    ) {}

    #[Route('/new', name: 'event_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $event = new Event();
            $event->setBarid($data['bar']);
            $event->setBandid($data['band']);
            $event->setDate($data['date']);
            $event->setTime($data['time']);
            $event->setStatus(StatusEnum::pending);

            $error = $this->validator->validate($event);

            if ($error) {
                return $this->json($error, 422);
            }

            $this->entityManager->persist($event);
            $this->entityManager->flush();

            return $this->json($event, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'event_list', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $events = $this->eventRepository->findAll();

        try {
            return $this->json($events, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'event_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        if (!$event) {
            return $this->json(['error' => 'Event not found'], 404);
        }

        try {
            return $this->json($event, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
