<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_has_order")
 */
class ProductHasOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="ProductQte")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="ProductQte")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Orders
    {
        return $this->Order;
    }

    public function setOrder(?Orders $Order): self
    {
        $this->Order = $Order;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): ?self
    {
        $this->quantity = $quantity;

        return $this;
    }
}