<?php

namespace App\Entity;

use App\Repository\PointRuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRuleRepository::class)]
class PointRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $scanType = null;

    #[ORM\Column(length: 50)]
    private ?string $calculationMethod = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $value = null;

    #[ORM\Column(nullable: true)]
    private ?int $maxPointsPerDay = null;

    #[ORM\ManyToOne(inversedBy: 'pointRules')]
    private ?Tier $guestTier = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $updatedBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScanType(): ?string
    {
        return $this->scanType;
    }

    public function setScanType(string $scanType): static
    {
        $this->scanType = $scanType;

        return $this;
    }

    public function getCalculationMethod(): ?string
    {
        return $this->calculationMethod;
    }

    public function setCalculationMethod(string $calculationMethod): static
    {
        $this->calculationMethod = $calculationMethod;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getMaxPointsPerDay(): ?int
    {
        return $this->maxPointsPerDay;
    }

    public function setMaxPointsPerDay(?int $maxPointsPerDay): static
    {
        $this->maxPointsPerDay = $maxPointsPerDay;

        return $this;
    }

    public function getGuestTier(): ?Tier
    {
        return $this->guestTier;
    }

    public function setGuestTier(?Tier $guestTier): static
    {
        $this->guestTier = $guestTier;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): static
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
