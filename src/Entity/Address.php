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
     * @ORM\Column(type="string", length=200)
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
     * @ORM\Column(type="smallint")
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
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $elevator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     */
    private $customer;

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

    public function getCustomerId(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomerId(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
