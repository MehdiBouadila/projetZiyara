<?php

namespace App\Entity;

use App\Repository\ReservationPackRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationPackRepository::class)]
class ReservationPack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Please select a departure date.")]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateReservationPack = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Please put number")]
    private ?int $nbrParticipantPack = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Pack $pack = null;

    #[ORM\ManyToOne(inversedBy: 'reservationPacks')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservationPack(): ?\DateTimeInterface
    {
        return $this->dateReservationPack;
    }

    public function setDateReservationPack(\DateTimeInterface $dateReservationPack): static
    {
        $this->dateReservationPack = $dateReservationPack;

        return $this;
    }

    public function getNbrParticipantPack(): ?int
    {
        return $this->nbrParticipantPack;
    }

    public function setNbrParticipantPack(int $nbrParticipantPack): static
    {
        $this->nbrParticipantPack = $nbrParticipantPack;

        return $this;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): static
    {
        $this->pack = $pack;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
