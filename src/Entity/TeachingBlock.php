<?php

namespace App\Entity;

use App\Repository\TeachingBlockRepository;
use Doctrine\Common\Collections\ArrayCollection; 
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeachingBlockRepository::class)]
class TeachingBlock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column()]
    private ?int $hours_count = null;

    #[ORM\OneToMany(mappedBy: 'teachingBlock', targetEntity: Module::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $modules;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

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

    public function setHoursCount(?int $hours_count): static
    {
        $this->hours_count = $hours_count;

        return $this;
    }

    public function getModules() : Collection 
    { 
        return $this->modules; 
    }

    // Ajoute un module à la bloc pédagogique et met à jour l’autre côté de la relation.
    public function addModule(Module $module): static
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
            $module->setTeachingBlock($this);
        }

        return $this;
    }

    // Retire un module à la bloc pédagogique et met à jour l’autre côté de la relation.
    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            if ($module->getTeachingBlock() === $this) {
                $module->setTeachingBlock(null);
            }
        }

        return $this;
    }
}
