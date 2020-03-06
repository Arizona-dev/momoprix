<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $schedule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery;

    /**
     * @ORM\Column(type="date")
     */
    private $date_delivery;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\address", inversedBy="deliveries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address_idaddress;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\order", inversedBy="delivery", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_idorder;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSchedule(): ?string
    {
        return $this->schedule;
    }

    public function setSchedule(string $schedule): self
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function getDelivery(): ?\DateTimeInterface
    {
        return $this->delivery;
    }

    public function setDelivery(\DateTimeInterface $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function getDateDelivery(): ?\DateTimeInterface
    {
        return $this->date_delivery;
    }

    public function setDateDelivery(\DateTimeInterface $date_delivery): self
    {
        $this->date_delivery = $date_delivery;

        return $this;
    }

    public function getAddressIdaddress(): ?address
    {
        return $this->address_idaddress;
    }

    public function setAddressIdaddress(?address $address_idaddress): self
    {
        $this->address_idaddress = $address_idaddress;

        return $this;
    }

    public function getOrderIdorder(): ?order
    {
        return $this->order_idorder;
    }

    public function setOrderIdorder(order $order_idorder): self
    {
        $this->order_idorder = $order_idorder;

        return $this;
    }
}
