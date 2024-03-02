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
    #[Assert\Positive(
          message:"le valeur doit etre positive"
    )]
    private ?int $nbrparticipantVisite = null;

    #[ORM\ManyToOne(inversedBy: 'reservationVisites')]
    private ?User $idUser = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        match: true,
        message: "Le nom ne peut contenir que des lettres"
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\p{L}+$/u',
        match: true,
        message: "Le prenom ne peut contenir que des lettres"
    )]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\NotNull]
    #[Assert\Positive(
        message:"le valeur doit etre positive"
  )]
    private ?int $numtlph = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;
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

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumtlph(): ?int
    {
        return $this->numtlph;
    }

    public function setNumtlph(int $numtlph): static
    {
        $this->numtlph = $numtlph;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
