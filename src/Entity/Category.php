<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[UniqueEntity(
    fields:['name'],
    errorPath: 'name',
    message: 'This item already exists in database.'
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: SubCategory::class)]
    private Collection $subCategories;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: MonthlyConsumption::class)]
    private Collection $monthlyConsumptions;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Mc::class)]
    private Collection $mcs;

    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
        $this->monthlyConsumptions = new ArrayCollection();
        $this->mcs = new ArrayCollection();
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
     * @return Collection<int, SubCategory>
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): static
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories->add($subCategory);
            $subCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): static
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategory() === $this) {
                $subCategory->setCategory(null);
            }
        }

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
            $monthlyConsumption->setCategory($this);
        }

        return $this;
    }

    public function removeMonthlyConsumption(MonthlyConsumption $monthlyConsumption): static
    {
        if ($this->monthlyConsumptions->removeElement($monthlyConsumption)) {
            // set the owning side to null (unless already changed)
            if ($monthlyConsumption->getCategory() === $this) {
                $monthlyConsumption->setCategory(null);
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
            $mc->setCategory($this);
        }

        return $this;
    }

    public function removeMc(Mc $mc): static
    {
        if ($this->mcs->removeElement($mc)) {
            // set the owning side to null (unless already changed)
            if ($mc->getCategory() === $this) {
                $mc->setCategory(null);
            }
        }

        return $this;
    }
}
