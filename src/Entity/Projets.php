<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProjet = null;

    #[ORM\Column]
    private ?float $montantProjet = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\Column(nullable: true)]
    private ?float $temps_projet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getMontantProjet(): ?float
    {
        return $this->montantProjet;
    }

    public function setMontantProjet(float $montantProjet): self
    {
        $this->montantProjet = $montantProjet;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getTempsProjet(): ?float
    {
        return $this->temps_projet;
    }

    public function setTempsProjet(?float $temps_projet): self
    {
        $this->temps_projet = $temps_projet;

        return $this;
    }
}
