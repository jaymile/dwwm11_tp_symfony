<?php

namespace App\Entity;

use App\Repository\ProfRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfRepository::class)
 */
class Prof {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=Classe::class, mappedBy="professeurPrincipal")
     */
    private $clasesPrincipales;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="professeurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matiere;

    public function __construct() {
        $this->clasesPrincipales = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection|Classe[]
     */
    public function getClasesPrincipales(): Collection {
        return $this->clasesPrincipales;
    }

    public function addClasesPrincipale(Classe $clasesPrincipale): self {
        if (!$this->clasesPrincipales->contains($clasesPrincipale)) {
            $this->clasesPrincipales[] = $clasesPrincipale;
            $clasesPrincipale->setProfesseurPrincipal($this);
        }

        return $this;
    }

    public function removeClasesPrincipale(Classe $clasesPrincipale): self {
        if ($this->clasesPrincipales->removeElement($clasesPrincipale)) {
            // set the owning side to null (unless already changed)
            if ($clasesPrincipale->getProfesseurPrincipal() === $this) {
                $clasesPrincipale->setProfesseurPrincipal(null);
            }
        }

        return $this;
    }

    public function getMatiere(): ?Matiere {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self {
        $this->matiere = $matiere;

        return $this;
    }

    public function getDisplayedName() {
        return $this->prenom . ' ' . strtoupper($this->nom);
    }
}
