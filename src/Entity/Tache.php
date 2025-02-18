<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projet $projetId = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Statut $statutId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employe $employeId = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deadline = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjetId(): ?Projet
    {
        return $this->projetId;
    }

    public function setProjetId(?Projet $projetId): static
    {
        $this->projetId = $projetId;

        return $this;
    }

    public function getStatutId(): ?Statut
    {
        return $this->statutId;
    }

    public function setStatutId(?Statut $statutId): static
    {
        $this->statutId = $statutId;

        return $this;
    }

    public function getEmployeId(): ?Employe
    {
        return $this->employeId;
    }

    public function setEmployeId(?Employe $employeId): static
    {
        $this->employeId = $employeId;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }
}
