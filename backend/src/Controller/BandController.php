<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/band')]
final class BandController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private BandRepository $bandRepository,
        private ValidatorInterface $validator
    ) {}

    #[Route('/new', name: 'band_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $band = new Band();
            $band->setName($data['name'] ?? '');
            $band->setDescription($data['description'] ?? '');

            $error = $this->validator->validate($band);

            if ($error) {
                return $this->json($error, 422);
            }

            $this->entityManager->persist($band);
            $this->entityManager->flush();

            return $this->json($band, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'band_list', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $band = $this->bandRepository->findAll();

        try {
            return $this->json($band, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'band_show', methods: ['GET'], format: 'json')]
    public function show(int $id): JsonResponse
    {
        $bar = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($bar)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            return $this->json($bar, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}/edit', name: 'band_edit', methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        $band = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($bar)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            $band->setName($data['name'] ?? '');
            $band->setDescription($data['description'] ?? '');

            $error = $this->validator->validate($band);

            if ($error) {
                return $this->json($error, 422);
            }

            $this->entityManager->flush();

            return $this->json($band, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'band_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        if (!isset($id)) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        $band = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($bar)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            $this->entityManager->remove($band);
            $this->entityManager->flush();

            return $this->json(["message" => "band deleted"], 200);
        } catch (\Exception $exception) {
            return $this->json(["error" => $exception->getMessage()], 500);
        }
    }
}
