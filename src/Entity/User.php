<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: ReservationPack::class, mappedBy: 'user')]
    private Collection $reservationPacks;

    public function __construct()
    {
        $this->reservationPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, ReservationPack>
     */
    public function getReservationPacks(): Collection
    {
        return $this->reservationPacks;
    }

    public function addReservationPack(ReservationPack $reservationPack): static
    {
        if (!$this->reservationPacks->contains($reservationPack)) {
            $this->reservationPacks->add($reservationPack);
            $reservationPack->setUser($this);
        }

        return $this;
    }

    public function removeReservationPack(ReservationPack $reservationPack): static
    {
        if ($this->reservationPacks->removeElement($reservationPack)) {
            // set the owning side to null (unless already changed)
            if ($reservationPack->getUser() === $this) {
                $reservationPack->setUser(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->email;
    }
}
