<?php

namespace App\Entity;

use App\Repository\GuideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GuideRepository::class)]
class Guide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank( message: "Le nom du guide ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: '/^\D*$/',
        message: "Nom cannot contain numbers."
    )]
    
    #[ORM\Column(length: 255)]
    private ?string $NomGuide = null;

    #[ORM\Column(length: 255)]
    private ?string $PrenomGuide = null;

    #[ORM\Column(length: 255)]
    private ?string $Langue = null;

    #[ORM\Column(length: 255)]
    private ?string $Disponibilite = null;

    #[ORM\Column(length: 255)]
    private ?string $ImageGuide = null;

    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'guide')]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getid(): ?int
    {
        return $this->id;
    }

    public function getNomGuide(): ?string
    {
        return $this->NomGuide;
    }

    public function setNomGuide(string $NomGuide): static
    {
        $this->NomGuide = $NomGuide;

        return $this;
    }

    public function getPrenomGuide(): ?string
    {
        return $this->PrenomGuide;
    }

    public function setPrenomGuide(string $PrenomGuide): static
    {
        $this->PrenomGuide = $PrenomGuide;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->Langue;
    }

    public function setLangue(string $Langue): static
    {
        $this->Langue = $Langue;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->Disponibilite;
    }

    public function setDisponibilite(string $Disponibilite): static
    {
        $this->Disponibilite = $Disponibilite;

        return $this;
    }

    public function getImageGuide(): ?string
    {
        return $this->ImageGuide;
    }

    public function setImageGuide(string $ImageGuide): static
    {
        $this->ImageGuide = $ImageGuide;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setGuide($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getGuide() === $this) {
                $reservation->setGuide(null);
            }
        }

        return $this;
    }
}
