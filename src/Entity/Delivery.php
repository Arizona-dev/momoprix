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
     * @ORM\Column(type="date")
     */
    private $dateDelivery;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order", cascade={"persist", "remove"})
     */
    private $Order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     */
    private $address;

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

    public function getDateDelivery(): ?\DateTimeInterface
    {
        return $this->dateDelivery;
    }

    public function setDateDelivery(\DateTimeInterface $date_delivery): self
    {
        $this->dateDelivery = $date_delivery;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->Order;
    }

    public function setOrderId(?Order $Order): self
    {
        $this->Order = $Order;

        return $this;
    }

    public function getAddressId(): ?Address
    {
        return $this->address;
    }

    public function setAddressId(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
