<?php

namespace App\Entity;

use App\Repository\AssignedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssignedRepository::class)]
class Assigned
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Project::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private $project;

    
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private $time_production;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide')]
    private $employee;

    #[ORM\Column(type: 'datetime')]
    private $published_at;

    public function __construct()
    {
        $this->published_at = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }


    public function getTimeProduction(): ?int
    {
        return $this->time_production;
    }

    public function setTimeProduction(int $time_production): self
    {
        $this->time_production = $time_production;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getpublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setpublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }
}
