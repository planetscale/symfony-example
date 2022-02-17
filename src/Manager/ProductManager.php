<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class ProductManager
{
    private \Doctrine\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->productRepository = $entityManager->getRepository('App:Product');
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getProducts(): array
    {
        $connected = $this->entityManager->getConnection()->getDatabase();
        $schema = $this->entityManager->getConnection()->createSchemaManager();

        $products = $schema->tablesExist(['product']) ? $this->productRepository->findAll() : [];

        return ["connected" => $connected, "products" => $products];
    }


}