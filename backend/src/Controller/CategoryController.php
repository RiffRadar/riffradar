<?php

namespace App\Controller;

use App\DataTransferObject\CategoryDTO;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/category')]
final class CategoryController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ValidatorInterface     $validator,
        private readonly SerializerInterface    $serializer,
        private readonly CategoryRepository     $categoryRepository,
    )
    {
    }

    #[Route('/new', name: 'category_new', methods: ['POST'], format: 'json')]
    public function new(Request $request): JsonResponse
    {
        $jsonData = $request->getContent();

        if (!$jsonData) {
            return $this->json(['error' => 'invalid data'], 400);
        }

        try {
            $categoryDTO = $this->serializer->deserialize($jsonData, CategoryDTO::class, 'json');

            $error = $this->validator->validate($categoryDTO);

            if (count($error) > 0) {
                return $this->json($error, 422);
            }

            $category = new Category();
            $category->setName($categoryDTO->name);

            $parentCategory = $this->categoryRepository->findOneBy(['id' => $categoryDTO->category]);

            if ($parentCategory) {
                $parentCategory->addCategory($category);
            }

            $this->entityManager->persist($category);
            $this->entityManager->flush();

            return $this->json($category, 201);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }

    #[Route('/all', name: 'category_all', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $categories = $this->categoryRepository->findAll();

        try {
            return $this->json($categories, 200);
        } catch (Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], 500);
        }
    }
}
