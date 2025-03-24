<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\DTO\User\NewUserDTO;
use App\Entity\User;

#[Route('/api/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ) {}

    #[Route('/', name: 'user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->findOneUserById($id);

        if (empty($user)) {
            return $this->json(['error' => 'User not found'], 404);
        }

        try {
            return $this->json($user);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/new', name: 'user_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json(['error' => 'invalid data'], 404);
        }

        try {
            $userDTO = new NewUserDTO(
                $data['email'] ?? '',
                $data['password'] ?? ''
            );

            $user = new User();
            $user->setEmail($userDTO->email);
            $user->setPassword($userDTO->password);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json($user, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
