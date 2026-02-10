<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: TeachingBlock::class, inversedBy: 'modules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeachingBlock $teachingBlock = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true)]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $children;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: InstructorModule::class, cascade: ['persist', 'remove'])]
    private Collection $instructorModules;

    public function __construct()
    {
        $this->instructorModules = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
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

    public function getTeachingBlock(): ?TeachingBlock
    {
        return $this->teachingBlock;
    }

    public function setTeachingBlock(?TeachingBlock $teachingBlock): static
    {
        $this->teachingBlock = $teachingBlock;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function getInstructorModules(): Collection
    {
        return $this->instructorModules;
    }

    public function addInstructorModule(InstructorModule $instructorModule): static
    {
        if (!$this->instructorModules->contains($instructorModule)) {
            $this->instructorModules->add($instructorModule);
            $instructorModule->setModule($this);
        }

        return $this;
    }

    public function removeInstructorModule(InstructorModule $instructorModule): static
    {
        if ($this->instructorModules->removeElement($instructorModule)) {
            if ($instructorModule->getModule() === $this) {
                $instructorModule->setModule(null);
            }
        }

        return $this;
    }

    public function displayForSelect(?Module $parentModule = null): string
    {
        // displayname initialisé vide
        $displayname = '';

        // pas de parent ?

        $module = null !== $parentModule ? $parentModule : $this;

        if (null !== $module->parent) {
            $displayname .= $module->displayForSelect($module->parent).' / ';
        }

        $displayname .= $module->name;

        return $displayname;
    }
}
