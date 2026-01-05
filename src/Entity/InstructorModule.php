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

    #[ORM\Column]
    private ?int $instructor_id = null;

    #[ORM\Column]
    private ?int $module_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstructorId(): ?int
    {
        return $this->instructor_id;
    }

    public function setInstructorId(int $instructor_id): static
    {
        $this->instructor_id = $instructor_id;

        return $this;
    }

    public function getModuleId(): ?int
    {
        return $this->module_id;
    }

    public function setModuleId(int $module_id): static
    {
        $this->module_id = $module_id;

        return $this;
    }
}
