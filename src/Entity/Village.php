<?php

namespace App\Entity;

use App\Repository\VillageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VillageRepository::class)]
class Village
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $village_name = null;

    #[ORM\ManyToOne(inversedBy: 'villages')]
    private ?district $district = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVillageName(): ?string
    {
        return $this->village_name;
    }

    public function setVillageName(string $village_name): static
    {
        $this->village_name = $village_name;

        return $this;
    }

    public function getDistrict(): ?district
    {
        return $this->district;
    }

    public function setDistrict(?district $district): static
    {
        $this->district = $district;

        return $this;
    }
}
