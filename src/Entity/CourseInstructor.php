<?php

namespace App\Entity;

use App\Repository\CourseInstructorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseInstructorRepository::class)]
class CourseInstructor
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Course::class, inversedBy: 'courseInstructors')]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id', nullable: false)]
    private ?Course $course = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'courseInstructors')]
    #[ORM\JoinColumn(name: 'instructor_id', referencedColumnName: 'id', nullable: false)]
    private ?Instructor $instructor = null;

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;
        return $this;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): self
    {
        $this->instructor = $instructor;
        return $this;
    }
}