<?php


namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderContent;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderManager
{
    /** @var OrderRepository  */
    private $orderRepository;
    /** @var ProductManager  */
    private $productManager;
    /** @var EntityManagerInterface  */
    private $entityManager;
    /** @var StockManager  */
    private $stockManager;
    public function __construct(
        OrderRepository $orderRepository,
        StockManager $productManager,
        EntityManagerInterface $entityManager,
        StockManager $stockManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->productManager = $productManager;
        $this->entityManager = $entityManager;
        $this->stockManager = $stockManager;
    }
    public function placeOrder(int $orderId, array $contents)
    {
        $order = $this->orderRepository->find($orderId);
        if ($order) {
            throw new \Exception('Order already exists');
        }
        $order = new Order();
        $order->setId($orderId);
        foreach ($contents as $content) {
            $orderContent = new OrderContent();
            $orderContent->setHowManyItems($content['how_many'])
                ->setOrderReference($order)
                ->setProduct($this->productManager->get($content['product']));
            $this->stockManager->decreaseAvailableLots($content['product'], $content['how_many']);
            $order->addContent($orderContent);
            $this->entityManager->persist($orderContent);
        }
        $this->entityManager->flush();
    }
}