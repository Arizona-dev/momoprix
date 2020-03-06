<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $indoors;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $digicode;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="addresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer_idcustomer;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="address_idaddress")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Delivery", mappedBy="address_idaddress")
     */
    private $deliveries;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIndoors(): ?int
    {
        return $this->indoors;
    }

    public function setIndoors(int $indoors): self
    {
        $this->indoors = $indoors;

        return $this;
    }

    public function getDigicode(): ?string
    {
        return $this->digicode;
    }

    public function setDigicode(?string $digicode): self
    {
        $this->digicode = $digicode;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getElevator(): ?int
    {
        return $this->elevator;
    }

    public function setElevator(?int $elevator): self
    {
        $this->elevator = $elevator;

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

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setAddressIdaddress($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getAddressIdaddress() === $this) {
                $order->setAddressIdaddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Delivery[]
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries[] = $delivery;
            $delivery->setAddressIdaddress($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->contains($delivery)) {
            $this->deliveries->removeElement($delivery);
            // set the owning side to null (unless already changed)
            if ($delivery->getAddressIdaddress() === $this) {
                $delivery->setAddressIdaddress(null);
            }
        }

        return $this;
    }
}
