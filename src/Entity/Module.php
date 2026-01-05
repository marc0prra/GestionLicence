<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column(nullable: true)]
    private ?int $parent_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $hours_count = null;

    #[ORM\Column]
    private ?bool $capstone_project = null;

    #[ORM\Column]
    private ?int $teaching_block_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): static
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getHoursCount(): ?int
    {
        return $this->hours_count;
    }

    public function setHoursCount(int $hours_count): static
    {
        $this->hours_count = $hours_count;

        return $this;
    }

    public function isCapstoneProject(): ?bool
    {
        return $this->capstone_project;
    }

    public function setCapstoneProject(bool $capstone_project): static
    {
        $this->capstone_project = $capstone_project;

        return $this;
    }

    public function getTeachingBlockId(): ?int
    {
        return $this->teaching_block_id;
    }

    public function setTeachingBlockId(int $teaching_block_id): static
    {
        $this->teaching_block_id = $teaching_block_id;

        return $this;
    }
}
