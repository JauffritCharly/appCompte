<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte avec cet Email existe déja')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: Questionnaire::class)]
    private Collection $idQuestion;

    #[ORM\OneToMany(mappedBy: 'idUser', targetEntity: ArgentEconomisees::class)]
    private Collection $argentEconomisees;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageCompte = null;

    #[ORM\Column]
    private ?bool $QuestionnaireFait = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Projets::class, orphanRemoval: true)]
    private Collection $projets;


    public function __construct()
    {
        $this->idQuestion = new ArrayCollection();
        $this->argentEconomisees = new ArrayCollection();
        $this->projets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    /**
     * @return Collection<int, Questionnaire>
     */
    public function getIdQuestion(): Collection
    {
        return $this->idQuestion;
    }

    public function addIdQuestion(Questionnaire $idQuestion): self
    {
        if (!$this->idQuestion->contains($idQuestion)) {
            $this->idQuestion->add($idQuestion);
            $idQuestion->setIdUser($this);
        }

        return $this;
    }

    public function removeIdQuestion(Questionnaire $idQuestion): self
    {
        if ($this->idQuestion->removeElement($idQuestion)) {
            // set the owning side to null (unless already changed)
            if ($idQuestion->getIdUser() === $this) {
                $idQuestion->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ArgentEconomisees>
     */
    public function getArgentEconomisees(): Collection
    {
        return $this->argentEconomisees;
    }

    public function addArgentEconomisee(ArgentEconomisees $argentEconomisee): self
    {
        if (!$this->argentEconomisees->contains($argentEconomisee)) {
            $this->argentEconomisees->add($argentEconomisee);
            $argentEconomisee->setIdUser($this);
        }

        return $this;
    }

    public function removeArgentEconomisee(ArgentEconomisees $argentEconomisee): self
    {
        if ($this->argentEconomisees->removeElement($argentEconomisee)) {
            // set the owning side to null (unless already changed)
            if ($argentEconomisee->getIdUser() === $this) {
                $argentEconomisee->setIdUser(null);
            }
        }

        return $this;
    }

    public function getImageCompte(): ?string
    {
        return $this->imageCompte;
    }

    public function setImageCompte(?string $imageCompte): self
    {
        $this->imageCompte = $imageCompte;

        return $this;
    }

    public function isQuestionnaireFait(): ?bool
    {
        return $this->QuestionnaireFait;
    }

    public function setQuestionnaireFait(bool $QuestionnaireFait): self
    {
        $this->QuestionnaireFait = $QuestionnaireFait;

        return $this;
    }

    /**
     * @return Collection<int, Projets>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projets $projet): self
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setIdUser($this);
        }

        return $this;
    }

    public function removeProjet(Projets $projet): self
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getIdUser() === $this) {
                $projet->setIdUser(null);
            }
        }

        return $this;
    }

}
