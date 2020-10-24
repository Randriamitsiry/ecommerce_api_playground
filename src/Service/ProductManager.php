<?php


namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class ProductManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ProductRepository
     */
    private $productRepository;


    public function __construct(EntityManagerInterface  $entityManager, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return $product->getId();
    }

    /**
     * @param int $productId
     * @return Product
     * @throws EntityNotFoundException
     */
    public function get(int $productId)
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw new EntityNotFoundException('Product not found');
        }

        return $product;
    }

    public function setPrice(int $productId, float $price)
    {
        $product = $this->get($productId);
        $product->setPrice($price);
        $this->entityManager->flush();
    }
}