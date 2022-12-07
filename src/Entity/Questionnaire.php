<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionnaireRepository::class)]
class Questionnaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $salaire = null;

    #[ORM\Column(nullable: true)]
    private ?float $autreRevenus = null;

    #[ORM\Column(nullable: true)]
    private ?float $depenses = null;

    #[ORM\ManyToOne(inversedBy: 'idQuestion')]
    private ?User $idUser = null;

    #[ORM\Column]
    private ?int $methode_economie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getAutreRevenus(): ?float
    {
        return $this->autreRevenus;
    }

    public function setAutreRevenus(?float $autreRevenus): self
    {
        $this->autreRevenus = $autreRevenus;

        return $this;
    }

    public function getDepenses(): ?float
    {
        return $this->depenses;
    }

    public function setDepenses(?float $depenses): self
    {
        $this->depenses = $depenses;

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

    public function getMethodeEconomie(): ?int
    {
        return $this->methode_economie;
    }

    public function setMethodeEconomie(int $methode_economie): self
    {
        $this->methode_economie = $methode_economie;

        return $this;
    }

}
