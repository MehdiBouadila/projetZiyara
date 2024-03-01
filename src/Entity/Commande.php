<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Asser\NotNull]
    #[Assert\GreaterThan(value: 'today')]
    private ?\DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?float $total = null;

    #[ORM\Column(length: 255)]
    private ?string $type_paiement = null;

    #[ORM\ManyToMany(targetEntity: Produit::class)]
    private Collection $panier;

    #[ORM\Column(length: 255)]
    private ?string $iduser = null;

    public function __construct()
    {
        $this->panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->type_paiement;
    }

    public function setTypePaiement(string $type_paiement): static
    {
        $this->type_paiement = $type_paiement;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getPanier(): Collection
    {
        return $this->panier;
    }

    public function addPanier(Produit $panier): static
    {
        if (!$this->panier->contains($panier)) {
            $this->panier->add($panier);
        }

        return $this;
    }

    
    public function removePanier(Produit $panier): static
    {
        $this->panier->removeElement($panier);

        return $this;
    }
    

    public function getIduser(): ?string
    {
        return $this->iduser;
    }

    public function setIduser(string $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }
}
