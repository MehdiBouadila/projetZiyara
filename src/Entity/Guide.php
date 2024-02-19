<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuideRepository::class)]
class Guide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_guide = null;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGuide(): ?string
    {
        return $this->nom_guide;
    }

    public function setNomGuide(string $nom_guide): static
    {
        $this->nom_guide = $nom_guide;

        return $this;
    }
}
