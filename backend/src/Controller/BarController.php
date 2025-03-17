<?php

namespace App\Controller;

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
}
