<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getSkills"])]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    private ?string $language = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(["getSkills"])]
    private ?int $level = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    private ?string $yearOfExperience = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    private ?string $evaluation = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getSkills"])]
    private ?string $imgSource = null;

    /**
     * @var Collection<int, CategorySkill>
     */
    #[ORM\ManyToMany(targetEntity: CategorySkill::class, inversedBy: 'skills', cascade:['persist'])]
    #[Groups(["getSkills"])]
    private Collection $categorySkill;

    public function __construct()
    {
        $this->categorySkill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }


    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getYearOfExperience(): ?string
    {
        return $this->yearOfExperience;
    }

    public function setYearOfExperience(string $yearOfExperience): static
    {
        $this->yearOfExperience = $yearOfExperience;

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

    public function getEvaluation(): ?string
    {
        return $this->evaluation;
    }

    public function setEvaluation(string $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getImgSource(): ?string
    {
        return $this->imgSource;
    }

    public function setImgSource(string $imgSource): static
    {
        $this->imgSource = $imgSource;

        return $this;
    }

    /**
     * @return Collection<int, CategorySkill>
     */
    public function getCategorySkill(): Collection
    {
        return $this->categorySkill;
    }

    public function addCategorySkill(CategorySkill $categorySkill): static
    {
        if (!$this->categorySkill->contains($categorySkill)) {
            $this->categorySkill->add($categorySkill);
        }

        return $this;
    }

    public function removeCategorySkill(CategorySkill $categorySkill): static
    {
        $this->categorySkill->removeElement($categorySkill);

        return $this;
    }

    public function clearCategorySkills() : static
    {
        $this->categorySkill->clear();

        return $this;
    }

    public function __toString(): string
    {
        return $this->language;
    }
}
