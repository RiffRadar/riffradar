<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BarRepository;
use App\Entity\Bar;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/bar')]
final class BarController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private BarRepository $barRepository,
        private ValidatorInterface $validator
    ) {}

    #[Route('/new', name: 'bar_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $bar = new Bar();
            $bar->setName($data['name'] ?? '');
            $bar->setDescription($data['description'] ?? '');
            $bar->setAddress($data['address'] ?? '');
            $bar->setPostalCode($data['postalCode'] ?? '');
            $bar->setCity($data['city'] ?? '');

            $error = $this->validator->validate($bar);

            if ($error) {
                return $this->json($error, 422);
            }

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

    #[Route('/{id}/edit', name: 'bar_edit', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        $bar = $this->barRepository->findOneBy(['id' => $id]);

        if (!$bar) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            $bar->setName($data['name']);
            $bar->setDescription($data['description']);
            $bar->setAddress($data['address']);
            $bar->setPostalCode($data['postalCode']);
            $bar->setCity($data['city']);

            $error = $this->validator->validate($bar);

            if ($error) {
                return $this->json($error, 422);
            }

            $this->entityManager->flush();

            return $this->json($bar, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'bar_delete', methods: ['DELETE'])]
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
