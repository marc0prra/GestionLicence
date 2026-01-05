<?php

namespace App\Entity;

use App\Repository\InstructorModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorModuleRepository::class)]
class InstructorModule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'module_id')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instructor $instructor_id = null;

    #[ORM\Column]

    #[ORM\Column]

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructorId(): ?Instructor
    {
        return $this->instructor_id;
    }

    public function setInstructorId(?Instructor $instructor_id): static
    {
        $this->instructor_id = $instructor_id;

        return $this;
    }

    
}
