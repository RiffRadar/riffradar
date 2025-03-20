<?php

namespace App\Controller;

use App\DTO\Bar\NewBarDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BarRepository;
use App\Entity\Bar;

#[Route('/api/bars')]
final class BarController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private BarRepository $barRepository
    ) {}

    #[Route('/', name: 'bar')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BarController.php',
        ]);
    }

    #[Route('/all', name: 'bar_list', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $bar = $this->barRepository->getAll();

        if (empty($bar)) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            return $this->json($bar);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/{id}', name: 'bar_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $bar = $this->barRepository->findOneBarById($id);

        if (empty($bar)) {
            return $this->json(['error' => 'Bar not found'], 404);
        }

        try {
            return $this->json($bar);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/new', name: 'bar_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        try {
            $barDTO = new NewBarDTO(
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['address'] ?? '',
                $data['postalCode'] ?? '',
                $data['city'] ?? ''
            );

            $bar = new Bar();
            $bar->setName($barDTO->name);
            $bar->setDescription($barDTO->description);
            $bar->setAddress($barDTO->address);
            $bar->setPostalCode($barDTO->postalCode);
            $bar->setCity($barDTO->city);

            $this->entityManager->persist($bar);
            $this->entityManager->flush();

            return $this->json($bar, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
