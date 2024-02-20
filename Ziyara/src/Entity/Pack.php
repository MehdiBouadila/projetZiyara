<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $titre_Pack = null;

    #[ORM\Column(length: 255)]
    private ?string $description_Pack = null;

    #[ORM\Column(length: 255)]
    private ?string $prix_Pack = null;

    #[ORM\Column(length: 255)]
    private ?string $date_Pack = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPack(): ?string
    {
        return $this->id_Pack;
    }

    public function setIdPack(string $id_Pack): static
    {
        $this->id_Pack = $id_Pack;

        return $this;
    }

    public function getTitrePack(): ?string
    {
        return $this->titre_Pack;
    }

    public function setTitrePack(string $titre_Pack): static
    {
        $this->titre_Pack = $titre_Pack;

        return $this;
    }

    public function getDescriptionPack(): ?string
    {
        return $this->description_Pack;
    }

    public function setDescriptionPack(string $description_Pack): static
    {
        $this->description_Pack = $description_Pack;

        return $this;
    }

    public function getPrixPack(): ?string
    {
        return $this->prix_Pack;
    }

    public function setPrixPack(string $prix_Pack): static
    {
        $this->prix_Pack = $prix_Pack;

        return $this;
    }

    public function getDatePack(): ?string
    {
        return $this->date_Pack;
    }

    public function setDatePack(string $date_Pack): static
    {
        $this->date_Pack = $date_Pack;

        return $this;
    }
}
