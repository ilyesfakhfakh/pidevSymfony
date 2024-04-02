<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{

    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private string $Description ;

    #[ORM\Column(length: 255)]
    private ?string $Title;

    #[ORM\Column(length: 255)]
    private DateTime $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): Notification
    {
        $this->Description = $Description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): Notification
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): Notification
    {
        $this->date = $date;

        return $this;
    }
}