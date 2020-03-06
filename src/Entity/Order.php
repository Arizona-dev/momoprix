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
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $date_order;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $priceHT;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $priceTTC;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_payment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer_idcustomer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address_idaddress;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Delivery", mappedBy="order_idorder", cascade={"persist", "remove"})
     */
    private $delivery;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="product_has_order")
     */
    private $qte;

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
        return $this->date_order;
    }

    public function setDateOrder(\DateTimeInterface $date_order): self
    {
        $this->date_order = $date_order;

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
        return $this->date_payment;
    }

    public function setDatePayment(?\DateTimeInterface $date_payment): self
    {
        $this->date_payment = $date_payment;

        return $this;
    }

    public function getCustomerIdcustomer(): ?Customer
    {
        return $this->customer_idcustomer;
    }

    public function setCustomerIdcustomer(?Customer $customer_idcustomer): self
    {
        $this->customer_idcustomer = $customer_idcustomer;

        return $this;
    }

    public function getAddressIdaddress(): ?Address
    {
        return $this->address_idaddress;
    }

    public function setAddressIdaddress(?Address $address_idaddress): self
    {
        $this->address_idaddress = $address_idaddress;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(Delivery $delivery): self
    {
        $this->delivery = $delivery;

        // set the owning side of the relation if necessary
        if ($delivery->getOrderIdorder() !== $this) {
            $delivery->setOrderIdorder($this);
        }

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
}
