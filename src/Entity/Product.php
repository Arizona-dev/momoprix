<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private $name;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $bar_code;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_of_entry;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_idcategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_url;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", inversedBy="products")
     */
    private $product_has_order;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $qte;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", inversedBy="products")
     */
    private $wishlist;

    public function __construct()
    {
        $this->product_has_order = new ArrayCollection();
        $this->wishlist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategoryIdcategory(): ?int
    {
        return $this->category_idcategory;
    }

    public function setCategoryIdcategory(int $category_idcategory): self
    {
        $this->category_idcategory = $category_idcategory;

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

    /**
     * @return Collection|Order[]
     */
    public function getProductHasOrder(): Collection
    {
        return $this->product_has_order;
    }

    public function addProductHasOrder(Order $productHasOrder): self
    {
        if (!$this->product_has_order->contains($productHasOrder)) {
            $this->product_has_order[] = $productHasOrder;
        }

        return $this;
    }

    public function removeProductHasOrder(Order $productHasOrder): self
    {
        if ($this->product_has_order->contains($productHasOrder)) {
            $this->product_has_order->removeElement($productHasOrder);
        }

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(?int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getWishlist(): Collection
    {
        return $this->wishlist;
    }

    public function addWishlist(Customer $wishlist): self
    {
        if (!$this->wishlist->contains($wishlist)) {
            $this->wishlist[] = $wishlist;
        }

        return $this;
    }

    public function removeWishlist(Customer $wishlist): self
    {
        if ($this->wishlist->contains($wishlist)) {
            $this->wishlist->removeElement($wishlist);
        }

        return $this;
    }
}
