<?php

namespace App\Entity;

use App\Repository\FavorisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisRepository::class)]
class Favoris
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    private ?Visite $idVisite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdVisite(): ?Visite
    {
        return $this->idVisite;
    }

    public function setIdVisite(?Visite $idVisite): static
    {
        $this->idVisite = $idVisite;

        return $this;
    }
}
