<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[Broadcast]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'catt')]
    private Collection $tab;

    public function __construct()
    {
        $this->tab = new ArrayCollection();
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getTab(): Collection
    {
        return $this->tab;
    }

    public function addTab(Produit $tab): static
    {
        if (!$this->tab->contains($tab)) {
            $this->tab->add($tab);
            $tab->setCatt($this);
        }

        return $this;
    }

    public function removeTab(Produit $tab): static
    {
        if ($this->tab->removeElement($tab)) {
            // set the owning side to null (unless already changed)
            if ($tab->getCatt() === $this) {
                $tab->setCatt(null);
            }
        }

        return $this;
    }


  
   
   
}
