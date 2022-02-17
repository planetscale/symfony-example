<?php

namespace App\Twig;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    protected \Doctrine\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->categoryRepository = $entityManager->getRepository('App:Category');
    }

    public function getFunctions(): array
    {
        return [
          new TwigFunction('category', [$this, 'extractCategory']),
        ];
    }

    public function extractCategory(int $id): Category
    {
        return $this->categoryRepository->find($id);
    }
}