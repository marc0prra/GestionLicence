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

    #[ORM\Column]
    private ?int $user_id = null;

    /**
     * @var Collection<int, InstructorModule>
     */
    #[ORM\OneToMany(targetEntity: InstructorModule::class, mappedBy: 'instructor_id', orphanRemoval: true)]
    private Collection $module_id;

    #[ORM\OneToOne(inversedBy: 'instructor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->module_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, InstructorModule>
     */
    public function getModuleId(): Collection
    {
        return $this->module_id;
    }

    public function addModuleId(InstructorModule $moduleId): static
    {
        if (!$this->module_id->contains($moduleId)) {
            $this->module_id->add($moduleId);
            $moduleId->setInstructorId($this);
        }

        return $this;
    }

    public function removeModuleId(InstructorModule $moduleId): static
    {
        if ($this->module_id->removeElement($moduleId)) {
            // set the owning side to null (unless already changed)
            if ($moduleId->getInstructorId() === $this) {
                $moduleId->setInstructorId(null);
            }
        }

        return $this;
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
}
