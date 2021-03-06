<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ProductSearch {


    /**
     * @var int|null
     * @Assert\Range(min=1)
     */
    private $maxPrice;

    /**
     * @Assert\Range(min=0)
     * @var int|null
     */
    private $minPrice;


    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }


    /**
     * @param int|null $maxPrice
     * @return ProductSearch
     */
    public function setMaxPrice(int $maxPrice): ProductSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }


    /**
     * @param int|null $minPrice
     * @return ProductSearch
     */
    public function setMinPrice(int $minPrice): ProductSearch
    {
        $this->minPrice = $minPrice;
        return $this;
    }
}