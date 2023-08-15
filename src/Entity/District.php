<?php

namespace App\Entity;

use App\Repository\DistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistrictRepository::class)]
class District
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $district_name = null;

    #[ORM\OneToMany(mappedBy: 'district', targetEntity: Village::class)]
    private Collection $villages;

    public function __construct()
    {
        $this->villages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistrictName(): ?string
    {
        return $this->district_name;
    }

    public function setDistrictName(string $district_name): static
    {
        $this->district_name = $district_name;

        return $this;
    }

    /**
     * @return Collection<int, Village>
     */
    public function getVillages(): Collection
    {
        return $this->villages;
    }

    public function addVillage(Village $village): static
    {
        if (!$this->villages->contains($village)) {
            $this->villages->add($village);
            $village->setDistrict($this);
        }

        return $this;
    }

    public function removeVillage(Village $village): static
    {
        if ($this->villages->removeElement($village)) {
            // set the owning side to null (unless already changed)
            if ($village->getDistrict() === $this) {
                $village->setDistrict(null);
            }
        }

        return $this;
    }
}
