<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Tache;
use App\Entity\Employe;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'projet_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProjet = null;

    #[ORM\Column]
    private ?bool $archive = false;



    /**
     * @var Collection<int, Employe>
     */
    #[ORM\ManyToMany(targetEntity: Employe::class, inversedBy: 'projets')]
    #[ORM\JoinTable(name: 'projet_employe')]
    #[ORM\JoinColumn(name: 'projet_id', referencedColumnName: 'projet_id')]
    #[ORM\InverseJoinColumn(name: 'employe_id', referencedColumnName: 'employe_id')]
    private Collection $employes;

    public function __construct()
    {
        $this->employes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): static
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }


    public function isArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): static
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->addProjet($this);
        }
        return $this;
    }

    public function removeEmploye(Employe $employe): static
    {
        if ($this->employes->removeElement($employe)) {
            $employe->removeProjet($this);
        }
        return $this;
    }

    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'projet', cascade: ['persist', 'remove'])]
    private Collection $taches;

    public function getTaches(): Collection{
        return $this->taches;
    }
    public function addTache(Tache $tache): static{
        if (!$this->taches->contains($tache)) {
            $this->taches->add($tache);
            $tache->setProjet($this);

        }
        return $this;
    }
    public function removeTache(Tache $tache): static{
        if ($this->taches->removeElement($tache)) {
            $tache->setProjet(null);

        }
        return $this;
    }

}
