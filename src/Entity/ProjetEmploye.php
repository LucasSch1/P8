<?php

namespace App\Entity;

use App\Repository\ProjetEmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetEmployeRepository::class)]
class ProjetEmploye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Employe>
     */
    #[ORM\ManyToMany(targetEntity: Employe::class)]
    private Collection $employeId;

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\ManyToMany(targetEntity: Projet::class)]
    private Collection $projetId;

    public function __construct()
    {
        $this->employeId = new ArrayCollection();
        $this->projetId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployeId(): Collection
    {
        return $this->employeId;
    }

    public function addEmployeId(Employe $employeId): static
    {
        if (!$this->employeId->contains($employeId)) {
            $this->employeId->add($employeId);
        }

        return $this;
    }

    public function removeEmployeId(Employe $employeId): static
    {
        $this->employeId->removeElement($employeId);

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjetId(): Collection
    {
        return $this->projetId;
    }

    public function addProjetId(Projet $projetId): static
    {
        if (!$this->projetId->contains($projetId)) {
            $this->projetId->add($projetId);
        }

        return $this;
    }

    public function removeProjetId(Projet $projetId): static
    {
        $this->projetId->removeElement($projetId);

        return $this;
    }
}
