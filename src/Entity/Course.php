<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $start_date = null;

    #[ORM\Column]
    private ?\DateTime $end_date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CoursePeriod $course_period_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module_id = null;

    #[ORM\Column]
    private ?bool $remotely = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?InterventionType $intervention_type_id = null;

    #[ORM\OneToMany(mappedBy: 'course', targetEntity: CourseInstructor::class, cascade: ['persist', 'remove'])]
    private Collection $instructorLinks;

    public function __construct()
    {
        $this->instructorLinks = new ArrayCollection();
    }

    //Méthodes de classe
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getCoursePeriodId(): ?CoursePeriod
    {
        return $this->course_period_id;
    }

    public function setCoursePeriodId(?CoursePeriod $course_period_id): static
    {
        $this->course_period_id = $course_period_id;

        return $this;
    }

    public function getInterventionTypeId(): ?InterventionType
    {
        return $this->intervention_type_id;
    }

    public function setInterventionTypeId(?InterventionType $intervention_type_id): static
    {
        $this->intervention_type_id = $intervention_type_id;

        return $this;
    }

    public function getModuleId(): ?Module
    {
        return $this->module_id;
    }

    public function setModuleId(?Module $module_id): static
    {
        $this->module_id = $module_id;

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

    public function getInstructorLinks(): Collection
    {
        return $this->instructorLinks;
    }

    public function addInstructorLink(CourseInstructor $link): self
    {
        if (!$this->instructorLinks->contains($link)) {
            $this->instructorLinks->add($link);
            $link->setCourse($this);
        }
        return $this;
    }

    public function removeInstructorLink(CourseInstructor $link): self
    {
        if ($this->instructorLinks->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getCourse() === $this) {
                $link->setCourse(null);
            }
        }
        return $this;
    }
}
