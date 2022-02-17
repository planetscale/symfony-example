<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }


    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->getCategory());
        }

        $manager->flush();
    }

    public function getCategory(): Category
    {
        $category = new Category();
        $category->setName($this->faker->randomElement(['Fashion', 'Electronics', 'Appliances', 'Food', 'Health',]))
            ->setDescription($this->faker->text())
        ;
        return $category;
    }
}
