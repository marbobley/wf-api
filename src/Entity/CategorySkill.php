<?php

namespace App\Entity;

use App\Repository\CategorySkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorySkillRepository::class)]
class CategorySkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getSkills"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    #[Assert\NotBlank(message: "Le nom de la catégorie de compétence est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le nom de la catégorie de compétence doit faire au moins {{ limit }} caractères", maxMessage: "Le nom de la catégorie de compétence ne peut pas faire plus de {{ limit }} caractères.")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    #[Assert\NotBlank(message: "La description est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "La description doit faire au moins {{ limit }} caractères", maxMessage: "La description ne peut pas faire plus de {{ limit }} caractères.")]
    private ?string $description = null;

    /**
     * @var Collection<int, Skill>
     */
    #[ORM\ManyToMany(targetEntity: Skill::class, mappedBy: 'categorySkill')]
    private Collection $skills;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->addCategorySkill($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeCategorySkill($this);
        }

        return $this;
    }
}
