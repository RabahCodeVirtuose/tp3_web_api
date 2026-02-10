<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/courses/{id}/references',
    uriVariables: ['id' => new Link(fromClass: Cours::class, fromProperty: 'liste_references')],
    operations: [new GetCollection()],
)]

class Reference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $auteurs = [];

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $editeur_optionnel = null;

    #[ORM\Column(length: 255)]
    private ?string $type_id = null;

    #[ORM\ManyToOne(inversedBy: 'liste_references')]
    private ?Cours $cours = null;

    #[ORM\Column(length: 255)]
    private ?string $identifiant = null;

    #[ORM\Column]
    private ?int $date_de_publication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteurs(): array
    {
        return $this->auteurs;
    }

    public function setAuteurs(array $auteurs): static
    {
        $this->auteurs = $auteurs;

        return $this;
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

    public function getEditeurOptionnel(): ?string
    {
        return $this->editeur_optionnel;
    }

    public function setEditeurOptionnel(?string $editeur_optionnel): static
    {
        $this->editeur_optionnel = $editeur_optionnel;

        return $this;
    }

    public function getTypeId(): ?string
    {
        return $this->type_id;
    }

    public function setTypeId(string $type_id): static
    {
        $this->type_id = $type_id;

        return $this;
    }


    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): static
    {
        $this->cours = $cours;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getDateDePublication(): ?int
    {
        return $this->date_de_publication;
    }

    public function setDateDePublication(int $date_de_publication): static
    {
        $this->date_de_publication = $date_de_publication;

        return $this;
    }
}
