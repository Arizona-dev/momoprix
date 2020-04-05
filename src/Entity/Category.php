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
    private $category_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_url;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private $Category_has_category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="Category")
     */
    private $products;

    public function __construct()
    {
        $this->Category_has_category = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): self
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCategoryHasCategory(): Collection
    {
        return $this->Category_has_category;
    }

    public function addCategoryHasCategory(self $categoryHasCategory): self
    {
        if (!$this->Category_has_category->contains($categoryHasCategory)) {
            $this->Category_has_category[] = $categoryHasCategory;
        }

        return $this;
    }

    public function removeCategoryHasCategory(self $categoryHasCategory): self
    {
        if ($this->Category_has_category->contains($categoryHasCategory)) {
            $this->Category_has_category->removeElement($categoryHasCategory);
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
