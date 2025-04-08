<?php

namespace App\Controller;

use App\DataTransferObject\AvailabilityDTO;
use App\Entity\Availability;
use App\Repository\AvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/availability')]
final class AvailabilityController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AvailabilityRepository $availabilityRepository,
        private readonly ValidatorInterface     $validator,
        private readonly SerializerInterface    $serializer
    )
    {
    }

    #[Route('/new', name: 'availability_new', methods: ['POST'], format: 'json')]
    public function new(Request $request): JsonResponse
    {
        $jsonData = $request->getContent();

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $availabilityDTO = $this->serializer->deserialize($jsonData, AvailabilityDTO::class, 'json');

            $error = $this->validator->validate($availabilityDTO);

            if (count($error) > 0) {
                return $this->json($error, 422);
            }

            $bar = $this->availabilityRepository->findOneBy(['id' => $availabilityDTO->barId]);

            if (!$bar) {
                return new JsonResponse(['error' => 'bar not found'], 404);
            }

            $availability = new Availability();
            $availability->SetBar($bar);
            $availability->setDateTime($availabilityDTO->dateTime);

            $this->entityManager->persist($availability);
            $this->entityManager->flush();

            return $this->json($availability, 201);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}/edit', name: 'availability_show', methods: ['PUT'], format: 'json')]
    public function edit(): JsonResponse
    {

    }

    #[Route('/{id}/delete', name: 'availability_delete', methods: ['DELETE'], format: 'json')]
    public function delete(): JsonResponse
    {

    }
}
