<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
         #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $titre = null;

    #[ORM\ManyToOne]
    #[Assert\NotNull]
    private ?CategorieVisite $categorieVisite = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $descriptionVisite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\GreaterThan(
        value:"today")]
    private ?\DateTimeInterface $dateVisite = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 255)]
    #[Assert\File(maxSize: "10M")]
    private ?string $imagev = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCategorieVisite(): ?CategorieVisite
    {
        return $this->categorieVisite;
    }

    public function setCategorieVisite(?CategorieVisite $categorieVisite): static
    {
        $this->categorieVisite = $categorieVisite;

        return $this;
    }

    public function getDescriptionVisite(): ?string
    {
        return $this->descriptionVisite;
    }

    public function setDescriptionVisite(string $descriptionVisite): static
    {
        $this->descriptionVisite = $descriptionVisite;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): static
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImagev(): ?string
    {
        return $this->imagev;
    }

    public function setImagev(string $imagev): static
    {
        $this->imagev = $imagev;

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }
}
