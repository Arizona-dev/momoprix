<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Range(min=10000, max=9999999)
     */
    private $barCode;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\Range(min=0.1, max=500)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     * @Assert\Range(min=0.1, max=500)
     */
    private $priceWeight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0)
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specifications;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $Category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductHasOrder", mappedBy="Product", orphanRemoval=true)
     */
    private $ProductQte;

    public function __construct()
    {
        $this->ProductHasOrder = new ArrayCollection();
        $this->wishlist = new ArrayCollection();
        $this->createdAt = new \DateTime("now");
        $this->ProductQte = new ArrayCollection();
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

    public function getSlug()
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getBarCode(): ?string
    {
        return $this->barCode;
    }

    public function setBarCode(string $barCode): self
    {
        $this->barCode = $barCode;

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
        return $this->priceWeight;
    }

    public function setPriceWeight(?string $price_weight): self
    {
        $this->priceWeight = $price_weight;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = new \DateTime("now");

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
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

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

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    /**
     * @return Collection|ProductHasOrder[]
     */
    public function getProductQte(): Collection
    {
        return $this->ProductQte;
    }

    public function addProductQte(ProductHasOrder $productQte): self
    {
        if (!$this->ProductQte->contains($productQte)) {
            $this->ProductQte[] = $productQte;
            $productQte->setProduct($this);
        }

        return $this;
    }

    public function removeProductQte(ProductHasOrder $productQte): self
    {
        if ($this->ProductQte->contains($productQte)) {
            $this->ProductQte->removeElement($productQte);
            // set the owning side to null (unless already changed)
            if ($productQte->getProduct() === $this) {
                $productQte->setProduct(null);
            }
        }

        return $this;
    }

}
