<?php

namespace App\Entity;

use App\Repository\PopulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopulationRepository::class)]
class Population
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $family_count = null;

    #[ORM\Column(length: 255)]
    private ?string $pg_count = null;

    #[ORM\Column(length: 255)]
    private ?string $hostel_count = null;

    #[ORM\Column(length: 255)]
    private ?string $hotel_count = null;

    #[ORM\Column(length: 255)]
    private ?string $restaurant_count = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Location $location = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Region $region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyCount(): ?string
    {
        return $this->family_count;
    }

    public function setFamilyCount(string $family_count): static
    {
        $this->family_count = $family_count;

        return $this;
    }

    public function getPgCount(): ?string
    {
        return $this->pg_count;
    }

    public function setPgCount(string $pg_count): static
    {
        $this->pg_count = $pg_count;

        return $this;
    }

    public function getHostelCount(): ?string
    {
        return $this->hostel_count;
    }

    public function setHostelCount(string $hostel_count): static
    {
        $this->hostel_count = $hostel_count;

        return $this;
    }

    public function getHotelCount(): ?string
    {
        return $this->hotel_count;
    }

    public function setHotelCount(string $hotel_count): static
    {
        $this->hotel_count = $hotel_count;

        return $this;
    }

    public function getRestaurantCount(): ?string
    {
        return $this->restaurant_count;
    }

    public function setRestaurantCount(string $restaurant_count): static
    {
        $this->restaurant_count = $restaurant_count;

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
