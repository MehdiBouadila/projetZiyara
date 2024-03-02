<?php

namespace App\Entity;

use App\Repository\CategorieTransportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: CategorieTransportRepository::class)]
class CategorieTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    #[Assert\NotBlank(message: "Le nom de la catégorie de transport ne peut pas être vide")]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        match: true,
        message: "Le nom de la catégorie de transport ne peut contenir que des lettres"
    )]
    private ?string $nomCategorieTransport = null;

    public function __toString(): string
    {
        return $this->nomCategorieTransport ?? '';
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorieTransport(): ?string
    {
        return $this->nomCategorieTransport;
    }

    public function setNomCategorieTransport(string $nomCategorieTransport): static
    {
        $this->nomCategorieTransport = $nomCategorieTransport;

        return $this;
    }
}
