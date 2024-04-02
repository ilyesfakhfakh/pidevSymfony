<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Please enter your email')]
    #[Assert\Email(message: 'The email "{{ value }}" is not a valid email address')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
   
    #[Assert\Regex(
   pattern: '/[A-Z]/',
   message: 'Your password must contain at least one uppercase letter'
)]
#[Assert\Regex(
   pattern: '/[A-Z]/',
   message: 'Your password must contain at least one lowercase letter'
)]
#[Assert\Regex(
   pattern: '/\d/',
   message: 'Your password must contain at least one numeric character'
)]

private ?string $password = null;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]  
    #[Assert\NotBlank(message: 'Please enter your name')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Your name should be at least {{ limit }} characters', maxMessage: 'Your name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Your Name should contain only alphabetic letters'
    )]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Please enter your last name')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Your last name should be at least {{ limit }} characters', maxMessage: 'Your last name cannot be longer than {{ limit }} characters')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Your LastName should contain only alphabetic letters'
    )]
    private ?string $LastName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]

    private ?string $UserName = null;

    #[ORM\Column]
    private ?string $role = null;
    #[ORM\Column]
    private ?string $prefrole = null;

    #[ORM\Column]
    private ?string $ImagePath = null;
    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private bool $isBanned = false;
    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private bool $isVerified = false;
    #[ORM\Column]
    private ?string $ddn=null;

    #[ORM\OneToMany(targetEntity: Planification::class, mappedBy: 'id_driver')]
    private Collection $planification;

    public function __construct()
    {
        $this->planification = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->UserName;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function setUserName(?string $UserName): static
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }
    public function getPrefrole(): ?string
    {
        return $this->prefrole;
    }

    public function setPrefrole(string $prefrole): static
    {
        $this->prefrole = $prefrole;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->ImagePath;
    }

    public function setImagePath(string $ImagePath): static
    {
        $this->ImagePath = $ImagePath;

        return $this;
    }

    public function getIsBanned(): ?bool
{
    return $this->isBanned;
}

public function setIsBanned(bool $isBanned): self
{
    $this->isBanned = $isBanned;

    return $this;
}

public function getIsVerified(): ?bool
{
    return $this->isVerified;
}

public function setIsVerified(bool $isVerified): self
{
    $this->isVerified = $isVerified;

    return $this;
}


    public function getDdn(): ?string
    {
        return $this->ddn;
    }

    public function setDdn(string $ddn): static
    {
        $this->ddn = $ddn;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
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
            $planification->setIdDriver($this);
        }

        return $this;
    }

    public function removePlanification(Planification $planification): static
    {
        if ($this->planification->removeElement($planification)) {
            // set the owning side to null (unless already changed)
            if ($planification->getIdDriver() === $this) {
                $planification->setIdDriver(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }
}