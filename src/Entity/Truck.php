<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TruckRepository::class)]

class Truck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^\d{3}[A-Za-z]{2}\d{4}$/',
        message: "Matricule must follow the format: 3 numbers, 2 characters, 4 numbers"
    )]
    #[Assert\NotBlank(message:"Matricule is required")]
    private ?string $matricule = null;

    #[ORM\Column(length: 255)]
    private ?string $disponibilite = null;

    #[ORM\OneToMany(targetEntity: Waste::class, mappedBy: 'truck')]
    private Collection $wastes;

    public function __construct()
    {
        $this->wastes = new ArrayCollection();
    }

    
    

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * @return Collection<int, Waste>
     */
    public function getWastes(): Collection
    {
        return $this->wastes;
    }

    public function addWaste(Waste $waste): static
    {
        if (!$this->wastes->contains($waste)) {
            $this->wastes->add($waste);
            $waste->setTruck($this);
        }

        return $this;
    }

    public function removeWaste(Waste $waste): static
    {
        if ($this->wastes->removeElement($waste)) {
            // set the owning side to null (unless already changed)
            if ($waste->getTruck() === $this) {
                $waste->setTruck(null);
            }
        }

        return $this;
    }
 public function __toString()
    {
        return $this->matricule;
    }
    
}