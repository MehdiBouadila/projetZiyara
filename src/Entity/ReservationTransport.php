<?php

namespace App\Entity;

use App\Repository\ReservationTransportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ReservationTransportRepository::class)]
class ReservationTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_user_id", referencedColumnName: "id",nullable: false)]
    private ?User $idUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: "Veuillez fournir une date de réservation.")]
    #[Assert\GreaterThan("today", message: "La date de Reservation doit être ultérieure à la date d'aujourd'hui")]
    private ?\DateTimeInterface $dateReservationTransport = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez fournir le point de depart.")]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        match: true,
        message: "Le pointDepart ne peut contenir que des lettres"
    )]
    private ?string $pointDepart = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez fournir le point de Arrive.")]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        match: true,
        message: "Le pointArrive ne peut contenir que des lettres"
    )]
    private ?string $pointArrive = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_transport", nullable: false)]
    private ?Transport $idTransport = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateReservationTransport(): ?\DateTimeInterface
    {
        return $this->dateReservationTransport;
    }

    public function setDateReservationTransport(\DateTimeInterface $dateReservationTransport): static
    {
        $this->dateReservationTransport = $dateReservationTransport;

        return $this;
    }

    public function getPointDepart(): ?string
    {
        return $this->pointDepart;
    }

    public function setPointDepart(string $pointDepart): static
    {
        $this->pointDepart = $pointDepart;

        return $this;
    }

    public function getPointArrive(): ?string
    {
        return $this->pointArrive;
    }

    public function setPointArrive(string $pointArrive): static
    {
        $this->pointArrive = $pointArrive;

        return $this;
    }

    public function getIdTransport(): ?Transport
    {
        return $this->idTransport;
    }

    public function setIdTransport(?Transport $idTransport): static
    {
        $this->idTransport = $idTransport;

        return $this;
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

    

}
