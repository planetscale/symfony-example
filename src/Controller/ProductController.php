<?php

namespace App\Controller;

use App\Manager\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ProductManager $productManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductManager $productManager,
    )
    {
        $this->entityManager = $entityManager;
        $this->productManager = $productManager;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    #[Route('/', name: 'product')]
    public function index(): Response
    {
        $result = $this->productManager->getProducts();

        return $this->render('product/index.html.twig', [
            'products' => $result['products'],
            'connected' => $result['connected']
        ]);
    }
}
