<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/courses/{id}/programs',
    uriVariables: ['id' => new Link(fromClass: Cours::class, fromProperty: 'programmes')],
    operations: [new GetCollection()],
)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sous_titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nombre_de_semestres = null;

    #[ORM\Column]
    private ?int $nombre_de_credits = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'depends_on')]
    private ?self $programme = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'programme')]
    private Collection $depends_on;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\ManyToMany(targetEntity: Cours::class, inversedBy: 'programmes')]
    private Collection $cours_de_ce_programme;

    #[ORM\ManyToOne(inversedBy: 'est_resp_programme')]
    private ?Enseignant $enseignant = null;

    public function __construct()
    {
        $this->depends_on = new ArrayCollection();
        $this->cours_de_ce_programme = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSousTitre(): ?string
    {
        return $this->sous_titre;
    }

    public function setSousTitre(?string $sous_titre): static
    {
        $this->sous_titre = $sous_titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNombreDeSemestres(): ?int
    {
        return $this->nombre_de_semestres;
    }

    public function setNombreDeSemestres(int $nombre_de_semestres): static
    {
        $this->nombre_de_semestres = $nombre_de_semestres;

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

    public function getProgramme(): ?self
    {
        return $this->programme;
    }

    public function setProgramme(?self $programme): static
    {
        $this->programme = $programme;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getDependsOn(): Collection
    {
        return $this->depends_on;
    }

    public function addDependsOn(self $dependsOn): static
    {
        if (!$this->depends_on->contains($dependsOn)) {
            $this->depends_on->add($dependsOn);
            $dependsOn->setProgramme($this);
        }

        return $this;
    }

    public function removeDependsOn(self $dependsOn): static
    {
        if ($this->depends_on->removeElement($dependsOn)) {
            // set the owning side to null (unless already changed)
            if ($dependsOn->getProgramme() === $this) {
                $dependsOn->setProgramme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCoursDeCeProgramme(): Collection
    {
        return $this->cours_de_ce_programme;
    }

    public function addCoursDeCeProgramme(Cours $coursDeCeProgramme): static
    {
        if (!$this->cours_de_ce_programme->contains($coursDeCeProgramme)) {
            $this->cours_de_ce_programme->add($coursDeCeProgramme);
        }

        return $this;
    }

    public function removeCoursDeCeProgramme(Cours $coursDeCeProgramme): static
    {
        $this->cours_de_ce_programme->removeElement($coursDeCeProgramme);

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
}
