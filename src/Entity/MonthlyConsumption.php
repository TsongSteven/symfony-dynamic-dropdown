<?php

namespace App\Entity;

use App\Repository\MonthlyConsumptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonthlyConsumptionRepository::class)]
class MonthlyConsumption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $weight = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyConsumptions')]
    private ?Location $location = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyConsumptions')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyConsumptions')]
    private ?SubCategory $sub_category = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyConsumptions')]
    private ?Property $property = null;

    #[ORM\Column(length: 255)]
    private ?string $unit = null;

    // public function __construct()
    // {
    //     $this->location = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): static
    {
        $this->weight = $weight;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->sub_category;
    }

    public function setSubCategory(?SubCategory $sub_category): static
    {
        $this->sub_category = $sub_category;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): static
    {
        $this->property = $property;

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
}
