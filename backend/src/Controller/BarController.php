<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BarRepository;
use App\Entity\Bar;
use App\DataTransferObject\BarDTO;

#[Route('/api/bar')]
final class BarController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly BarRepository $barRepository,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
    ) {}

    #[Route('/new', name: 'bar_new', methods: ['POST'], format: 'json')]
    public function new(Request $request): JsonResponse
    {
        $jsonData = $request->getContent();

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $barDTO = $this->serializer->deserialize($jsonData, BarDTO::class, 'json');

            $error = $this->validator->validate($barDTO);

            if (count($error) > 0) {
                return $this->json($error, 422);
            }

            $bar = new Bar();
            $bar->setName($barDTO->name);
            $bar->setDescription($barDTO->description);
            $bar->setAddress($barDTO->address);
            $bar->setPostalCode($barDTO->postalCode);
            $bar->setCity($barDTO->city);
            $bar->setTelephone($barDTO->telephone);
            $bar->setCoverImage($barDTO->coverImage);

            $this->entityManager->persist($bar);
            $this->entityManager->flush();

            return $this->json($bar, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'bar_list', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $bar = $this->barRepository->findAll();

        try {
            return $this->json($bar, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'bar_show', methods: ['GET'], format: 'json')]
    public function show(int $id): JsonResponse
    {
        $bar = $this->barRepository->findOneBy(['id' => $id]);

        if (!$bar) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            return $this->json($bar, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}/edit', name: 'bar_edit', methods: ['PUT'], format: 'json')]
    public function update(Request $request, int $id): JsonResponse
    {
        $jsonData = $request->getContent();

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        $bar = $this->barRepository->findOneBy(['id' => $id]);

        if (!$bar) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            $barDTO = $this->serializer->deserialize($jsonData, BarDTO::class, 'json');

            $error = $this->validator->validate($barDTO);

            if (count($error) > 0) {
                return $this->json($error, 422);
            }

            $bar->setName($barDTO->name);
            $bar->setDescription($barDTO->description);
            $bar->setAddress($barDTO->address);
            $bar->setPostalCode($barDTO->postalCode);
            $bar->setCity($barDTO->city);
            $bar->setTelephone($barDTO->telephone);
            $bar->setCoverImage($barDTO->coverImage);

            $error = $this->validator->validate($bar);

            $this->entityManager->flush();

            return $this->json($bar, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'bar_delete', methods: ['DELETE'], format: 'json')]
    public function delete(int $id): JsonResponse
    {
        if (!isset($id)) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        $bar = $this->barRepository->findOneBy(['id' => $id]);

        if (!$bar) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            $this->entityManager->remove($bar);
            $this->entityManager->flush();

            return $this->json(["message" => "bar deleted"], 200);
        } catch (\Exception $exception) {
            return $this->json(["error" => $exception->getMessage()], 500);
        }
    }
}
