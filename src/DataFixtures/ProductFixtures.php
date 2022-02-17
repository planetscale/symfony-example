<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->getProduct($i));
        }

        $manager->flush();
    }

    public function getProduct($i): Product
    {
        $product = new Product();
        $product->setName('Product ' . $i + 1)
            ->setDescription($this->faker->text())
            ->setImage('https://via.placeholder.com/150')
            ->setCategoryId($this->faker->numberBetween(1,10))
        ;

        return $product;
    }

}
