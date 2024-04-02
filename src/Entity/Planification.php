<?php

namespace App\Entity;

use App\Repository\PlanificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PlanificationRepository::class)]
class Planification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_plan = null;

    

    

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'location should contain only alphabetic letters'
    )]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'planification')]
    #[ORM\JoinColumn(name: 'id_mission',referencedColumnName:'id_mission')]
    #[Assert\NotBlank(message:"id mission is required")]
    private ?Mission $mission = null;

    #[ORM\ManyToOne(inversedBy: 'planification')]
    #[ORM\JoinColumn(name: 'id_driver',referencedColumnName:'id')]
    #[Assert\NotBlank(message:"id driver is required")]
    private ?User $id_driver = null;

    public function getIdPlan(): ?int
    {
        return $this->id_plan;
    }

    

    
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): static
    {
        $this->mission = $mission;

        return $this;
    }

    public function getIdDriver(): ?User
    {
        return $this->id_driver;
    }

    public function setIdDriver(?User $id_driver): static
    {
        $this->id_driver = $id_driver;

        return $this;
    }
}
