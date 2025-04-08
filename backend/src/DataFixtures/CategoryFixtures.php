<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName("category$i");

            $manager->persist($category);

            for ($j = 1; $j <= 2; $j++) {
                $subCategory = new Category();
                $subCategory->setName("subCategory$j");
                $subCategory->setCategory($category);

                $manager->persist($subCategory);
            }
        }

        $manager->flush();
    }
}
