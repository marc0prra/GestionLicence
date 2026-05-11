<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use App\Validator as AssertSpe;
use App\Validator\CourseDateLength;
use App\Validator\CourseDatesWithinPeriod;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[AssertSpe\IntervenantHasModule]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Renseignez une date de début.')]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTime $startDate = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Renseignez une date de fin.')]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(
        propertyPath: 'startDate',
        message: 'La date de fin doit être postérieure à la date de début.'
    )]
    #[CourseDateLength]
    #[CourseDatesWithinPeriod]
    private ?\DateTime $endDate = null;

    #[ORM\Column]
    private ?bool $remotely = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePeriod $coursePeriod = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?InterventionType $interventionType = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseInstructor::class, cascade: ['persist', 'remove'])]
    private Collection $courseInstructors;

    public function __construct()
    {
        $this->courseInstructors = new ArrayCollection();
    }

    // Méthodes de classe
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCoursePeriod(): ?CoursePeriod
    {
        return $this->coursePeriod;
    }

    public function setCoursePeriod(?CoursePeriod $coursePeriod): static
    {
        $this->coursePeriod = $coursePeriod;

        return $this;
    }

    public function getInterventionType(): ?InterventionType
    {
        return $this->interventionType;
    }

    public function setInterventionType(?InterventionType $interventionType): static
    {
        $this->interventionType = $interventionType;

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

    public function isRemotely(): ?bool
    {
        return $this->remotely;
    }

    public function setRemotely(bool $remotely): static
    {
        $this->remotely = $remotely;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCourseInstructors(): Collection
    {
        return $this->courseInstructors;
    }

    public function addCourseInstructor(CourseInstructor $courseInstructor): static
    {
        if (!$this->courseInstructors->contains($courseInstructor)) {
            $this->courseInstructors->add($courseInstructor);
            $courseInstructor->setCourse($this);
        }

        return $this;
    }

    public function removeCourseInstructor(CourseInstructor $courseInstructor): static
    {
        if ($this->courseInstructors->removeElement($courseInstructor)) {
            if ($courseInstructor->getCourse() === $this) {
                $courseInstructor->setCourse(null);
            }
        }

        return $this;
    }
}
