<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Please enter a title.")]
    #[ORM\Column(length: 255)]
    private ?string $titrePack = null;

    #[Assert\NotBlank(message: "Please enter a description.")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionPack = null;

    #[Assert\NotBlank(message: "Please enter a price.")]
    #[ORM\Column]
    private ?int $prixPack = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePack = null;

    #[Assert\NotBlank(message: "Please select a departure date.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDepartPack = null;

    #[Assert\NotBlank(message: "Please select an arrival date.")]
    #[Assert\GreaterThan(propertyPath: "dateDepartPack", message: "The arrival date must be after the departure date.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateArrivePack = null;

    #[ORM\OneToMany(targetEntity: ReservationPack::class, mappedBy: 'pack')]
    private Collection $reservations;

    #[ORM\OneToOne]
    private ?Transport $transports = null;

    #[ORM\OneToOne]
    private ?Guide $guide = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePack(): ?string
    {
        return $this->titrePack;
    }

    public function setTitrePack(string $titrePack): static
    {
        $this->titrePack = $titrePack;

        return $this;
    }

    public function getDescriptionPack(): ?string
    {
        return $this->descriptionPack;
    }

    public function setDescriptionPack(string $descriptionPack): static
    {
        $this->descriptionPack = $descriptionPack;

        return $this;
    }

    public function getPrixPack(): ?int
    {
        return $this->prixPack;
    }

    public function setPrixPack(int $prixPack): static
    {
        $this->prixPack = $prixPack;

        return $this;
    }

    public function getImagePack(): ?string
    {
        return $this->imagePack;
    }

    public function setImagePack(string $imagePack): static
    {
        $this->imagePack = $imagePack;

        return $this;
    }

    public function getDateDepartPack(): ?\DateTimeInterface
    {
        return $this->dateDepartPack;
    }

    public function setDateDepartPack(\DateTimeInterface $dateDepartPack): static
    {
        $this->dateDepartPack = $dateDepartPack;

        return $this;
    }

    public function getDateArrivePack(): ?\DateTimeInterface
    {
        return $this->dateArrivePack;
    }

    public function setDateArrivePack(\DateTimeInterface $dateArrivePack): static
    {
        $this->dateArrivePack = $dateArrivePack;

        return $this;
    }

    /**
     * @return Collection<int, ReservationPack>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(ReservationPack $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setPack($this);
        }

        return $this;
    }

    public function removeReservation(ReservationPack $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getPack() === $this) {
                $reservation->setPack(null);
            }
        }

        return $this;
    }

    public function getTransports(): ?Transport
    {
        return $this->transports;
    }

    public function setTransports(?Transport $transports): static
    {
        $this->transports = $transports;

        return $this;
    }

    public function getGuide(): ?Guide
    {
        return $this->guide;
    }

    public function setGuide(?Guide $guide): static
    {
        $this->guide = $guide;

        return $this;
    }
}
