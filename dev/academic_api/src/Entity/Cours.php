<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/programs/{id}/courses',
    uriVariables: ['id' => new Link(fromClass: Programme::class, toProperty: 'programmes')],
    operations: [new GetCollection()],
)]
#[ApiResource(
    uriTemplate: '/instructors/{id}/courses',
    uriVariables: ['id' => new Link(fromClass: Enseignant::class, fromProperty: 'est_enseignant_dans')],
    operations: [new GetCollection()],
)]
#[ApiResource(
    uriTemplate: '/references/{id}/courses',
    uriVariables: ['id' => new Link(fromClass: Reference::class, toProperty: 'liste_references')],
    operations: [new GetCollection()],
)]
#[ApiFilter(RangeFilter::class, properties: ['semestre', 'nombre_de_credits', 'nb_cm', 'nb_td', 'nb_tp'])]
#[ApiFilter(SearchFilter::class, properties: ['programmes.id' => 'exact'])]
#[ApiFilter(BooleanFilter::class, properties: ['isOptionnel'])]

class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $nombre_de_credits = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $syllabus = null;

    #[ORM\Column]
    private ?int $semestre = null;

    #[ORM\Column]
    private ?int $nb_cm = null;

    #[ORM\Column]
    private ?int $nb_td = null;

    #[ORM\Column]
    private ?int $nb_tp = null;

    #[ORM\Column]
    private ?bool $isOptionnel = null;

    /**
     * @var Collection<int, Programme>
     */
    #[ORM\ManyToMany(targetEntity: Programme::class, mappedBy: 'cours_de_ce_programme')]
    private Collection $programmes;

    #[ORM\ManyToOne(inversedBy: 'est_resp_cours')]
    private ?Enseignant $enseignant = null;

    /**
     * @var Collection<int, Enseignant>
     */
    #[ORM\ManyToMany(targetEntity: Enseignant::class, mappedBy: 'est_enseignant_dans')]
    private Collection $enseignants;

    /**
     * @var Collection<int, Reference>
     */
    #[ORM\OneToMany(targetEntity: Reference::class, mappedBy: 'cours')]
    private Collection $liste_references;



    public function __construct()
    {
        $this->programmes = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
        $this->liste_references = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNombreDeCredits(): ?int
    {
        return $this->nombre_de_credits;
    }

    public function setNombreDeCredits(int $nombre_de_credits): static
    {
        $this->nombre_de_credits = $nombre_de_credits;

        return $this;
    }

    public function getSyllabus(): ?string
    {
        return $this->syllabus;
    }

    public function setSyllabus(string $syllabus): static
    {
        $this->syllabus = $syllabus;

        return $this;
    }

    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getNbCm(): ?int
    {
        return $this->nb_cm;
    }

    public function setNbCm(int $nb_cm): static
    {
        $this->nb_cm = $nb_cm;

        return $this;
    }

    public function getNbTd(): ?int
    {
        return $this->nb_td;
    }

    public function setNbTd(int $nb_td): static
    {
        $this->nb_td = $nb_td;

        return $this;
    }

    public function getNbTp(): ?int
    {
        return $this->nb_tp;
    }

    public function setNbTp(int $nb_tp): static
    {
        $this->nb_tp = $nb_tp;

        return $this;
    }

    public function isOptionnel(): ?bool
    {
        return $this->isOptionnel;
    }

    public function setIsOptionnel(bool $isOptionnel): static
    {
        $this->isOptionnel = $isOptionnel;

        return $this;
    }

    /**
     * @return Collection<int, Programme>
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): static
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes->add($programme);
            $programme->addCoursDeCeProgramme($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): static
    {
        if ($this->programmes->removeElement($programme)) {
            $programme->removeCoursDeCeProgramme($this);
        }

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * @return Collection<int, Enseignant>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(Enseignant $enseignant): static
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants->add($enseignant);
            $enseignant->addEstEnseignantDan($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): static
    {
        if ($this->enseignants->removeElement($enseignant)) {
            $enseignant->removeEstEnseignantDan($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reference>
     */
    public function getListeReferences(): Collection
    {
        return $this->liste_references;
    }

    public function addListeReference(Reference $listeReference): static
    {
        if (!$this->liste_references->contains($listeReference)) {
            $this->liste_references->add($listeReference);
            $listeReference->setCours($this);
        }

        return $this;
    }

    public function removeListeReference(Reference $listeReference): static
    {
        if ($this->liste_references->removeElement($listeReference)) {
            // set the owning side to null (unless already changed)
            if ($listeReference->getCours() === $this) {
                $listeReference->setCours(null);
            }
        }

        return $this;
    }



}
