<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
#[ApiResource(operations: [new Get(), new GetCollection()])]
#[ApiResource(
    uriTemplate: '/courses/{id}/instructors',
    uriVariables: ['id' => new Link(fromClass: Cours::class, fromProperty: 'enseignants')],
    operations: [new GetCollection()],
)]
class Enseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $poste = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\OneToMany(targetEntity: Programme::class, mappedBy: 'enseignant')]
    private Collection $est_resp_programme;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'enseignant')]
    private Collection $est_resp_cours;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\ManyToMany(targetEntity: Cours::class, inversedBy: 'enseignants')]
    private Collection $est_enseignant_dans;


    public function __construct()
    {
        $this->est_resp_programme = new ArrayCollection();
        $this->est_resp_cours = new ArrayCollection();
        $this->est_enseignant_dans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getEstRespProgramme(): Collection
    {
        return $this->est_resp_programme;
    }

    public function addEstRespProgramme(Programme $estRespProgramme): static
    {
        if (!$this->est_resp_programme->contains($estRespProgramme)) {
            $this->est_resp_programme->add($estRespProgramme);
            $estRespProgramme->setEnseignant($this);
        }

        return $this;
    }

    public function removeEstRespProgramme(Programme $estRespProgramme): static
    {
        if ($this->est_resp_programme->removeElement($estRespProgramme)) {
            // set the owning side to null (unless already changed)
            if ($estRespProgramme->getEnseignant() === $this) {
                $estRespProgramme->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getEstRespCours(): Collection
    {
        return $this->est_resp_cours;
    }

    public function addEstRespCour(Cours $estRespCour): static
    {
        if (!$this->est_resp_cours->contains($estRespCour)) {
            $this->est_resp_cours->add($estRespCour);
            $estRespCour->setEnseignant($this);
        }

        return $this;
    }

    public function removeEstRespCour(Cours $estRespCour): static
    {
        if ($this->est_resp_cours->removeElement($estRespCour)) {
            // set the owning side to null (unless already changed)
            if ($estRespCour->getEnseignant() === $this) {
                $estRespCour->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getEstEnseignantDans(): Collection
    {
        return $this->est_enseignant_dans;
    }

    public function addEstEnseignantDan(Cours $estEnseignantDan): static
    {
        if (!$this->est_enseignant_dans->contains($estEnseignantDan)) {
            $this->est_enseignant_dans->add($estEnseignantDan);
        }

        return $this;
    }

    public function removeEstEnseignantDan(Cours $estEnseignantDan): static
    {
        $this->est_enseignant_dans->removeElement($estEnseignantDan);

        return $this;
    }


}
