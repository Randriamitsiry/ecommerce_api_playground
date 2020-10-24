<?php

namespace App\Entity;

use App\Repository\OrderContentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderContentRepository::class)
 */
class OrderContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $howManyItems;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="contents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderReference;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getHowManyItems(): ?int
    {
        return $this->howManyItems;
    }

    public function setHowManyItems(int $howManyItems): self
    {
        $this->howManyItems = $howManyItems;

        return $this;
    }

    public function getOrderReference(): ?Order
    {
        return $this->orderReference;
    }

    public function setOrderReference(?Order $orderReference): self
    {
        $this->orderReference = $orderReference;

        return $this;
    }
}
