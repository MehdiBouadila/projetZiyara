<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    /*#[Assert\Image(
        maxSize: "10K",
        maxSizeMessage: "La taille de l'image ne peut pas dépasser 10 KB",
    )]*/
    private ?string $imageTransport = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Veuillez fournir une date")]
    #[Assert\GreaterThan(
        value: "today",
        message:  "La date de transport doit être ultérieure à la date d'aujourd'hui"
    )]
    private ?\DateTimeInterface $dateTransport = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuillez fournir un prix")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif")]
    private ?float $prixTransport = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Le nom de la catégorie de transport ne peut pas être vide")]
    private ?CategorieTransport $typeTransport = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function __toString(): string
    {
        return $this->id ?? '';
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageTransport(): ?string
    {
        return $this->imageTransport;
    }

    public function setImageTransport(string $imageTransport): static
    {
        $this->imageTransport = $imageTransport;

        return $this;
    }

   
    public function getDateTransport(): ?\DateTimeInterface
    {
        return $this->dateTransport;
    }

    public function setDateTransport(\DateTimeInterface $dateTransport): static
    {
        $this->dateTransport = $dateTransport;

        return $this;
    }

    public function getPrixTransport(): ?float
    {
        return $this->prixTransport;
    }

    public function setPrixTransport(float $prixTransport): static
    {
        $this->prixTransport = $prixTransport;

        return $this;
    }

    public function getTypeTransport(): ?CategorieTransport
    {
        return $this->typeTransport;
    }

    public function setTypeTransport(?CategorieTransport $typeTransport): static
    {
        $this->typeTransport = $typeTransport;

        return $this;
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
}
