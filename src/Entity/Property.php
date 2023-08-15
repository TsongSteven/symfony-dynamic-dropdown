<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: MonthlyConsumption::class)]
    private Collection $monthlyConsumptions;

    public function __construct()
    {
        $this->monthlyConsumptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, MonthlyConsumption>
     */
    public function getMonthlyConsumptions(): Collection
    {
        return $this->monthlyConsumptions;
    }

    public function addMonthlyConsumption(MonthlyConsumption $monthlyConsumption): static
    {
        if (!$this->monthlyConsumptions->contains($monthlyConsumption)) {
            $this->monthlyConsumptions->add($monthlyConsumption);
            $monthlyConsumption->setProperty($this);
        }

        return $this;
    }

    public function removeMonthlyConsumption(MonthlyConsumption $monthlyConsumption): static
    {
        if ($this->monthlyConsumptions->removeElement($monthlyConsumption)) {
            // set the owning side to null (unless already changed)
            if ($monthlyConsumption->getProperty() === $this) {
                $monthlyConsumption->setProperty(null);
            }
        }

        return $this;
    }
}
