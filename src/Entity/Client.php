<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idClient = null;

    #[ORM\Column(length: 30)]
    private ?string $nomClient = null;

    #[ORM\Column(length: 30)]
    private ?string $prenomClient = null;

    #[ORM\Column(length: 50)]
    private ?string $emailClient = null;

    #[ORM\Column(length: 30)]
    private ?string $mdpClient = null;

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }
    
    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(string $prenomClient): static
    {
        $this->prenomClient = $prenomClient;
        
        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): static
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getMdpClient(): ?string
    {
        return $this->mdpClient;
    }

    public function setMdpClient(string $mdpClient): static
    {
        $this->mdpClient = $mdpClient;

        return $this;
    }
}
