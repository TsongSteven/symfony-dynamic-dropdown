<?php

namespace App\Entity;

use App\Repository\McRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: McRepository::class)]
class Mc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $pg = null;

    #[ORM\Column(length: 255)]
    private ?string $hostel = null;

    #[ORM\Column(length: 255)]
    private ?string $hotel = null;

    #[ORM\Column(length: 255)]
    private ?string $restaurant = null;

    #[ORM\ManyToOne(inversedBy: 'mcs')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'mcs')]
    private ?Location $location = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    #[ORM\ManyToOne(inversedBy: 'mc')]
    private ?Region $region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getPg(): ?string
    {
        return $this->pg;
    }

    public function setPg(string $pg): static
    {
        $this->pg = $pg;

        return $this;
    }

    public function getHostel(): ?string
    {
        return $this->hostel;
    }

    public function setHostel(string $hostel): static
    {
        $this->hostel = $hostel;

        return $this;
    }

    public function getHotel(): ?string
    {
        return $this->hotel;
    }

    public function setHotel(string $hotel): static
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getRestaurant(): ?string
    {
        return $this->restaurant;
    }

    public function setRestaurant(string $restaurant): static
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }
}
