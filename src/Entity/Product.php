<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $product_name;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $bar_code;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $price_weight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_of_entry;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specifications;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", inversedBy="qte")
     */
    private $Product_has_Order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $Category;

    public function __construct()
    {
        $this->Product_has_Order = new ArrayCollection();
        $this->wishlist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getSlug()
    {
        return (new Slugify())->slugify($this->product_name);
    }

    public function getBarCode(): ?string
    {
        return $this->bar_code;
    }

    public function setBarCode(string $bar_code): self
    {
        $this->bar_code = $bar_code;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceWeight(): ?string
    {
        return $this->price_weight;
    }

    public function setPriceWeight(?string $price_weight): self
    {
        $this->price_weight = $price_weight;

        return $this;
    }

    public function getDateOfEntry(): ?\DateTimeInterface
    {
        return $this->date_of_entry;
    }

    public function setDateOfEntry(\DateTimeInterface $date_of_entry): self
    {
        $this->date_of_entry = $date_of_entry;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpecifications(): ?string
    {
        return $this->specifications;
    }

    public function setSpecifications(?string $specifications): self
    {
        $this->specifications = $specifications;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getProductHasOrder(): Collection
    {
        return $this->Product_has_Order;
    }

    public function addProductHasOrder(Order $productHasOrder): self
    {
        if (!$this->Product_has_Order->contains($productHasOrder)) {
            $this->Product_has_Order[] = $productHasOrder;
        }

        return $this;
    }

    public function removeProductHasOrder(Order $productHasOrder): self
    {
        if ($this->Product_has_Order->contains($productHasOrder)) {
            $this->Product_has_Order->removeElement($productHasOrder);
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }
}
