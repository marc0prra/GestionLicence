<?php

namespace App\Entity;

use App\Repository\InstructorModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorModuleRepository::class)]
class InstructorModule
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'instructorModules')]
    #[ORM\JoinColumn(name: 'instructor_id', referencedColumnName: 'id', nullable: false)]
    private ?Instructor $instructor = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Module::class, inversedBy: 'instructorModules')]
    #[ORM\JoinColumn(name: 'module_id', referencedColumnName: 'id', nullable: false)]
    private ?Module $module = null;

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): static
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }
}
