<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    private string $code;

    private ?int $parentId = null;

    private string $name;

    private ?string $description;

    private int $hoursCount;

    private bool $capstoneProject;

    private int $teachingBlockId;

    // GETTERS
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string 
    {
        return $this->$code;
    }

    public function getParentId(): ?int 
    {
        return $this->$parentId;
    }

    public function getName(): string 
    {
        return $this->$name;
    }

    public function getDescription(): ?string 
    {
        return $this->$description;
    }

    public function getHoursCount(): int 
    {
        return $this->$hoursCount;
    }

    public function getCapstoneProject(): bool 
    {
        return $this->$capstoneProject;
    }

    public function getTeachingBlockId(): int 
    {
        return $this->$teachingBlockId;
    }

    // SETTERS
    public function setCode($code) : void 
    {
        $this->$code = $code;
    }

    public function setParentId($parentId) : void 
    {
        $this->$parentId = $parentId;
    }

    public function setName($name) : void 
    {
        $this->$name = $name;
    }

    public function setDescription($description) : void 
    {
        $this->$description = $description;
    }

    public function setHoursCount($hoursCount) : void 
    {
        $this->$hoursCount = $hoursCount;
    }

    public function setCapstoneProject($capstoneProject) : void 
    {
        $this->$capstoneProject = $capstoneProject;
    }

    public function setTeachingBlockId($teachingBlockId) : void 
    {
        $this->$teachingBlockId = $teachingBlockId;
    }
}
