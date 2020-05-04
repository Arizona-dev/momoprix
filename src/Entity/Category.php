<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private $categoryHasCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="Category")
     */
    private $products;

    public function __construct()
    {
        $this->categoryHasCategory = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->imageUrl = $image_url;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategoryHasCategory(): Collection
    {
        return $this->categoryHasCategory;
    }

    public function addCategoryHasCategory(self $categoryHasCategory): self
    {
        if (!$this->categoryHasCategory->contains($categoryHasCategory)) {
            $this->categoryHasCategory[] = $categoryHasCategory;
        }

        return $this;
    }

    public function removeCategoryHasCategory(self $categoryHasCategory): self
    {
        if ($this->categoryHasCategory->contains($categoryHasCategory)) {
            $this->categoryHasCategory->removeElement($categoryHasCategory);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }
}
