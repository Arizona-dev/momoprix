<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateOrder;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $priceHT;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $priceTTC;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePayment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="ProductHasOrder")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders")
     */
    private $Customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     */
    private $Address;

    public function __construct()
    {
        $this->qte = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateOrder(): ?\DateTimeInterface
    {
        return $this->dateOrder;
    }

    public function setDateOrder(\DateTimeInterface $date_order): self
    {
        $this->dateOrder = $date_order;

        return $this;
    }

    public function getPriceHT(): ?string
    {
        return $this->priceHT;
    }

    public function setPriceHT(string $priceHT): self
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function getPriceTTC(): ?string
    {
        return $this->priceTTC;
    }

    public function setPriceTTC(string $priceTTC): self
    {
        $this->priceTTC = $priceTTC;

        return $this;
    }

    public function getDatePayment(): ?\DateTimeInterface
    {
        return $this->datePayment;
    }

    public function setDatePayment(?\DateTimeInterface $date_payment): self
    {
        $this->datePayment = $date_payment;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getQte(): Collection
    {
        return $this->qte;
    }

    public function addQte(Product $qte): self
    {
        if (!$this->qte->contains($qte)) {
            $this->qte[] = $qte;
            $qte->addProductHasOrder($this);
        }

        return $this;
    }

    public function removeQte(Product $qte): self
    {
        if ($this->qte->contains($qte)) {
            $this->qte->removeElement($qte);
            $qte->removeProductHasOrder($this);
        }

        return $this;
    }

    public function getCustomerId(): ?Customer
    {
        return $this->Customer;
    }

    public function setCustomerId(?Customer $Customer): self
    {
        $this->Customer = $Customer;

        return $this;
    }

    public function getAddressId(): ?Address
    {
        return $this->Address;
    }

    public function setAddressId(?Address $Address): self
    {
        $this->Address = $Address;

        return $this;
    }
}
