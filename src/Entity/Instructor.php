<?php

namespace App\Entity;

use App\Repository\InstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorRepository::class)]
class Instructor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'instructor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'instructor', targetEntity: InstructorModule::class, orphanRemoval: true)]
    private Collection $instructorModules;

    #[ORM\OneToMany(mappedBy: 'instructor', targetEntity: CourseInstructor::class, orphanRemoval: true)]
    private Collection $courseInstructors;

    public function __construct()
    {
        $this->instructorModules = new ArrayCollection();
        $this->courseInstructors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, InstructorModule>
     */
    public function getInstructorModules(): Collection
    {
        return $this->instructorModules;
    }

    public function addInstructorModule(InstructorModule $instructorModule): static
    {
        if (!$this->instructorModules->contains($instructorModule)) {
            $this->instructorModules->add($instructorModule);
            $instructorModule->setInstructor($this);
        }
        return $this;
    }

    public function removeInstructorModule(InstructorModule $instructorModule): static
    {
        if ($this->instructorModules->removeElement($instructorModule)) {
            if ($instructorModule->getInstructor() === $this) {
                $instructorModule->setInstructor(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, CourseInstructor>
     */
    public function getCourseInstructors(): Collection
    {
        return $this->courseInstructors;
    }

    public function addCourseInstructor(CourseInstructor $courseInstructor): static
    {
        if (!$this->courseInstructors->contains($courseInstructor)) {
            $this->courseInstructors->add($courseInstructor);
            $courseInstructor->setInstructor($this);
        }
        return $this;
    }

    public function removeCourseInstructor(CourseInstructor $courseInstructor): static
    {
        if ($this->courseInstructors->removeElement($courseInstructor)) {
            if ($courseInstructor->getInstructor() === $this) {
                $courseInstructor->setInstructor(null);
            }
        }
        return $this;
    }
}
