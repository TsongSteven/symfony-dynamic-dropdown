<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: MonthlyConsumption::class)]
    private Collection $monthlyConsumptions;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Mc::class)]
    private Collection $mcs;

    #[ORM\ManyToOne(inversedBy: 'location')]
    private ?Region $region = null;

    public function __construct()
    {
        $this->monthlyConsumptions = new ArrayCollection();
        $this->mcs = new ArrayCollection();
    }
    public function __toString(): string
    {
      return $this->name;
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
            $monthlyConsumption->setLocation($this);
        }

        return $this;
    }

    public function removeMonthlyConsumption(MonthlyConsumption $monthlyConsumption): static
    {
        if ($this->monthlyConsumptions->removeElement($monthlyConsumption)) {
            // set the owning side to null (unless already changed)
            if ($monthlyConsumption->getLocation() === $this) {
                $monthlyConsumption->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mc>
     */
    public function getMcs(): Collection
    {
        return $this->mcs;
    }

    public function addMc(Mc $mc): static
    {
        if (!$this->mcs->contains($mc)) {
            $this->mcs->add($mc);
            $mc->setLocation($this);
        }

        return $this;
    }

    public function removeMc(Mc $mc): static
    {
        if ($this->mcs->removeElement($mc)) {
            // set the owning side to null (unless already changed)
            if ($mc->getLocation() === $this) {
                $mc->setLocation(null);
            }
        }

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
