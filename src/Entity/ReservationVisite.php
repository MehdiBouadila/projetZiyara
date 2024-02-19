<?php

namespace App\Entity;

use App\Repository\ReservationVisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationVisiteRepository::class)]
class ReservationVisite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne]
    #[Assert\NotNull]
    private ?Visite $idVisite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull]
    #[Assert\GreaterThan(
        value:"today")]
    private ?\DateTimeInterface $dateReservationVisite = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive]
    private ?int $nbrparticipantVisite = null;
    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateReservationVisite(): ?\DateTimeInterface
    {
        return $this->dateReservationVisite;
    }

    public function setDateReservationVisite(\DateTimeInterface $dateReservationVisite): static
    {
        $this->dateReservationVisite = $dateReservationVisite;

        return $this;
    }

    public function getNbrparticipantVisite(): ?int
    {
        return $this->nbrparticipantVisite;
    }

    public function setNbrparticipantVisite(int $nbrparticipantVisite): static
    {
        $this->nbrparticipantVisite = $nbrparticipantVisite;

        return $this;
    }
}
