<?php

namespace App\Controller;

use App\DTO\Band\NewBandDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Band;
use App\Repository\BandRepository;

#[Route('/api/bands')]
final class BandController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private BandRepository $bandRepository,
    ) {}

    #[Route('/new', name: 'band_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $bandDTO = new NewBandDTO(
                $data['name'] ?? '',
                $data['description'] ?? '',
            );

            $band = new Band();
            $band->setName($bandDTO->name);
            $band->setDescription($bandDTO->description);

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
        $band = $this->bandRepository->getAll();

        if (empty($band)) {
            return $this->json(['error' => 'Band not found'], 404);
        }

        try {
            return $this->json($band);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
