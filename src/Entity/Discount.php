<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountRepository")
 */
class Discount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $discount_id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $discount_code;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $percentage;

    public function getDiscountId(): ?int
    {
        return $this->discount_id;
    }

    public function getDiscountCode(): ?string
    {
        return $this->discount_code;
    }

    public function setDiscountCode(string $discount_code): self
    {
        $this->discount_code = $discount_code;

        return $this;
    }

    public function getPercentage(): ?string
    {
        return $this->percentage;
    }

    public function setPercentage(string $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }
}
