<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Location::class)]
    private Collection $location;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Mc::class)]
    private Collection $mc;

    public function __construct()
    {
        $this->location = new ArrayCollection();
        $this->mc = new ArrayCollection();
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
     * @return Collection<int, Location>
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->location->contains($location)) {
            $this->location->add($location);
            $location->setRegion($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->location->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getRegion() === $this) {
                $location->setRegion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mc>
     */
    public function getMc(): Collection
    {
        return $this->mc;
    }

    public function addMc(Mc $mc): static
    {
        if (!$this->mc->contains($mc)) {
            $this->mc->add($mc);
            $mc->setRegion($this);
        }

        return $this;
    }

    public function removeMc(Mc $mc): static
    {
        if ($this->mc->removeElement($mc)) {
            // set the owning side to null (unless already changed)
            if ($mc->getRegion() === $this) {
                $mc->setRegion(null);
            }
        }

        return $this;
    }
}
