<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;
use App\DataTransferObject\BandDTO;


#[Route('/api/band')]
final class BandController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private BandRepository $bandRepository,
        private ValidatorInterface $validator,
        private readonly SerializerInterface $serializer
    ) {}

    #[Route('/new', name: 'band_new', methods: ['POST'], format: 'json')]
    public function new(Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $bandDTO = $this->serializer->deserialize($jsonData, BandDTO::class, 'json');

            $error = $this->validator->validate($bandDTO);

            if ($error) {
                return $this->json($error, 422);
            }

            $band = new Band();
            $band->setName($bandDTO->name);
            $band->setDescription($bandDTO->description);
            $band->setCoverImage($bandDTO->coverImage);
            $band->setEmbedLink($bandDTO->embedLink);

            $this->entityManager->persist($band);
            $this->entityManager->flush();

            return $this->json($band, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'band_list', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $bands = $this->bandRepository->findAll();

        try {
            return $this->json($bands, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'band_show', methods: ['GET'], format: 'json')]
    public function show(int $id): JsonResponse
    {
        $band = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($band)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            return $this->json($band, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}/edit', name: 'band_edit', methods: ['PUT'], format: 'json')]
    public function update(int $id, Request $request): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        $band = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($band)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            $bandDTO = $this->serializer->deserialize($jsonData, BandDTO::class, 'json');

            $error = $this->validator->validate($bandDTO);

            if ($error) {
                return $this->json($error, 422);
            }

            $band->setName($bandDTO->name);
            $band->setDescription($bandDTO->description);
            $band->setCoverImage($bandDTO->coverImage);
            $band->setEmbedLink($bandDTO->embedLink);

            $this->entityManager->flush();

            return $this->json($band, 200);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'band_delete', methods: ['DELETE'], format: 'json')]
    public function delete(int $id): JsonResponse
    {
        if (!isset($id)) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        $band = $this->bandRepository->findOneBy(['id' => $id]);

        if (empty($band)) {
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
