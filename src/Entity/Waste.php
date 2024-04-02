<?php

namespace App\Entity;

use App\Repository\WasteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Truck;
#[ORM\Entity(repositoryClass: WasteRepository::class)]
class Waste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id ;

    
    #[Assert\NotBlank(message:"type is required")]
    #[ORM\Column(length: 255)]
    public ?string $type ;

    #[Assert\NotBlank(message:"Location is required")]
    #[ORM\Column(length: 255)]
    public ?string $location ;

    #[Assert\NotBlank(message:"etat is required")]
    #[ORM\Column(length: 255)]
    public ?string $etat ;

    #[Assert\NotBlank(message:"quantite is required")]
    #[ORM\Column(length: 255)]
    public ?string $quantite ;

    #[ORM\ManyToOne(inversedBy: 'wastes')]
    public ?Truck $truck ;

    public function __construct(
        ?int $id = null,
        ?string $type = null,
        ?string $location = null,
        ?string $etat = null,
        ?string $quantite = null,
        ?Truck $truck = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->location = $location;
        $this->etat = $etat;
        $this->quantite = $quantite;
        $this->truck = $truck;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    

    
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

   
    /*public function __toString()
    {
        return $this->$truck;
    }*/

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): static
    {
        $this->truck = $truck;

        return $this;
    }

    public function __toString(){
        return $this->id;
    }
}