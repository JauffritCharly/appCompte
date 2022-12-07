<?php

namespace App\Entity;

use App\Repository\ArgentEconomiseesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArgentEconomiseesRepository::class)]
class ArgentEconomisees
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $economie = null;

    #[ORM\ManyToOne(inversedBy: 'argentEconomisees')]
    private ?User $idUser = null;

    #[ORM\Column(nullable: true)]
    private ?float $ArgentTotal = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEconomie(): ?float
    {
        return $this->economie;
    }

    public function setEconomie(?float $economie): self
    {
        $this->economie = $economie;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getArgentTotal(): ?float
    {
        return $this->ArgentTotal;
    }

    public function setArgentTotal(?float $ArgentTotal): self
    {
        $this->ArgentTotal = $ArgentTotal;

        return $this;
    }


}
