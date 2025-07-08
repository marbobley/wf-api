<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $level = null;

    #[ORM\Column(length: 255)]
    private ?string $yearOfExperience = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $evaluation = null;

    #[ORM\Column(length: 255)]
    private ?string $imgSource = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

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
}
