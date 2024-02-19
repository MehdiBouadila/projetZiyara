<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prix_transport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixTransport(): ?int
    {
        return $this->prix_transport;
    }

    public function setPrixTransport(int $prix_transport): static
    {
        $this->prix_transport = $prix_transport;

        return $this;
    }
}
