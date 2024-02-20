<?php

namespace App\Entity;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Broadcast]

class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    private ?int$prix = null;

    #[ORM\Column(length: 255)]
    private ?string $cat = null;

    #[ORM\ManyToOne(inversedBy: 'tab')]
    private ?Categorie $catt = null;


    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): static
    {
        $this->cat = $cat;

        return $this;
    }

    public function getCatt(): ?Categorie
    {
        return $this->catt;
    }

    public function setCatt(?Categorie $catt): static
    {
        $this->catt = $catt;

        return $this;
    }
    
}
