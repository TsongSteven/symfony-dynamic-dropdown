<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SubCategoryRepository::class)]
#[UniqueEntity(
    fields: ['name'],
    errorPath: 'name',
    message: 'This item already exists in database'
)]
class SubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subCategories') ] 
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'sub_category', targetEntity: MonthlyConsumption::class)]
    private Collection $monthlyConsumptions;

    public function __construct()
    {
        $this->monthlyConsumptions = new ArrayCollection();
    }

    public function __toString()
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $monthlyConsumption->setSubCategory($this);
        }

        return $this;
    }

    public function removeMonthlyConsumption(MonthlyConsumption $monthlyConsumption): static
    {
        if ($this->monthlyConsumptions->removeElement($monthlyConsumption)) {
            // set the owning side to null (unless already changed)
            if ($monthlyConsumption->getSubCategory() === $this) {
                $monthlyConsumption->setSubCategory(null);
            }
        }

        return $this;
    }

}
