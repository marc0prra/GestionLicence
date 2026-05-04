<?php

namespace App\Entity;

use App\Repository\UnaivibilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UnaivibilityRepository::class)]
class Unaivibility
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Type("\DateTimeInterface")]
    private \DateTime $startDate;

    #[ORM\Column]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\GreaterThan(propertyPath: 'startDate', message: 'La date de fin doit être supérieur à la date de début.')]
    private \DateTime $endDate;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reason  = null;

    #[ORM\ManyToOne(targetEntity: Instructor::class, inversedBy: 'unaivibilities')]
    private Instructor $instructor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): \DateTime 
    {
        return $this->startDate;
    }

    public function getEndDate(): \DateTime 
    {
        return $this->endDate;
    }

    public function getReason(): ?string 
    {
        return $this->reason;
    }

    public function getInstructor(): Instructor
    {
        return $this->instructor;
    }

    public function setStartDate(\DateTime $newStartDate): static 
    {
        $this->startDate = $newStartDate;

        return $this;
    }

    public function setEndDate(\DateTime $newEndDate): static 
    {
        $this->endDate = $newEndDate;

        return $this;
    }

    public function setReason(?string $newReason): static 
    {
        $this->reason = $newReason;

        return $this;
    }

    public function setInstructor(?Instructor $newInstructor): static 
    {
        $this->instructor = $newInstructor;

        return $this;
    }
}
