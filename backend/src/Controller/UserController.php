<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/user')]
final class UserController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private ValidatorInterface $validator
    ) {}

    #[Route('/{id}', name: 'user_show', methods: ['GET'], format: 'json')]
    public function show(int $id): JsonResponse
    {

        $user = $this->userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        try {
            return $this->json($user, 200);
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
            $user = new User();
            $user->setEmail($data['email'] ?? '');
            $user->setPassword(password: $data['password']?? '');
            $user->setFirstName($data['firstname'] ?? '');
            $user->setLastName($data['lastname'] ?? ''  );

            $error = $this->validator->validate($user);

            if ($error) {
                return $this->json($error, 422);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json($user, 201);
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
