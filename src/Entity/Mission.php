<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_mission = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('today')
    ]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('today')
    ]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255)]
    
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    
    private ?string $type_d = null;

    #[ORM\Column(length: 255)]
    
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Planification::class, mappedBy: 'mission')]
    private Collection $planification;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    
    private ?Truck $truck = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Assert\NotBlank(message:"id waste is required")]
    
    private ?Waste $id_waste = null;

    public function __construct()
    {
        $this->planification = new ArrayCollection();
    }

    
    public function getIdMission(): ?int
    {
        return $this->id_mission;
    }

 
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTypeD(): ?string
    {
        return $this->type_d;
    }

    public function setTypeD(string $type_d): static
    {
        $this->type_d = $type_d;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Planification>
     */
    public function getPlanification(): Collection
    {
        return $this->planification;
    }

    public function addPlanification(Planification $planification): static
    {
        if (!$this->planification->contains($planification)) {
            $this->planification->add($planification);
            $planification->setMission($this);
        }

        return $this;
    }

    public function removePlanification(Planification $planification): static
    {
        if ($this->planification->removeElement($planification)) {
            // set the owning side to null (unless already changed)
            if ($planification->getMission() === $this) {
                $planification->setMission(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->id_mission;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    public function getIdWaste(): ?Waste
    {
        return $this->id_waste;
    }

    public function setIdWaste(?Waste $id_waste): static
    {
        $this->id_waste = $id_waste;

        return $this;
    }
    
}
