<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TierRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
    ],
    normalizationContext: ['groups' => ['tier:read']],
    denormalizationContext: ['groups' => ['tier:write']]
)]
class Tier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['tier:read', 'tier:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['tier:read', 'tier:write'])]
    private ?int $minPointsRequired = null;

    #[ORM\Column]
    #[Groups(['tier:read', 'tier:write'])]
    private ?int $maxPointsAllowed = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tier:read', 'tier:write'])]
    private ?string $badgeIconUrl = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['tier:read', 'tier:write'])]
    private ?array $perks = null;

    #[ORM\Column]
    #[Groups(['tier:read', 'tier:write'])]
    private ?bool $active = null;

    #[ORM\Column]
    #[Groups(['tier:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Customer>
     */
    #[ORM\OneToMany(targetEntity: Customer::class, mappedBy: 'tier')]
    #[Groups(['tier:read'])]
    private Collection $customers;

    /**
     * @var Collection<int, PointRule>
     */
    #[ORM\OneToMany(targetEntity: PointRule::class, mappedBy: 'guestTier')]
    #[Groups(['tier:read'])]
    private Collection $pointRules;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->pointRules = new ArrayCollection();
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

    public function getMinPointsRequired(): ?int
    {
        return $this->minPointsRequired;
    }

    public function setMinPointsRequired(int $minPointsRequired): static
    {
        $this->minPointsRequired = $minPointsRequired;

        return $this;
    }

    public function getMaxPointsAllowed(): ?int
    {
        return $this->maxPointsAllowed;
    }

    public function setMaxPointsAllowed(int $maxPointsAllowed): static
    {
        $this->maxPointsAllowed = $maxPointsAllowed;

        return $this;
    }

    public function getBadgeIconUrl(): ?string
    {
        return $this->badgeIconUrl;
    }

    public function setBadgeIconUrl(?string $badgeIconUrl): static
    {
        $this->badgeIconUrl = $badgeIconUrl;

        return $this;
    }

    public function getPerks(): ?array
    {
        return $this->perks;
    }

    public function setPerks(?array $perks): static
    {
        $this->perks = $perks;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist] // This ensures the field is auto-filled only on creation, not updates.
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setTier($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getTier() === $this) {
                $customer->setTier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PointRule>
     */
    public function getPointRules(): Collection
    {
        return $this->pointRules;
    }

    public function addPointRule(PointRule $pointRule): static
    {
        if (!$this->pointRules->contains($pointRule)) {
            $this->pointRules->add($pointRule);
            $pointRule->setGuestTier($this);
        }

        return $this;
    }

    public function removePointRule(PointRule $pointRule): static
    {
        if ($this->pointRules->removeElement($pointRule)) {
            // set the owning side to null (unless already changed)
            if ($pointRule->getGuestTier() === $this) {
                $pointRule->setGuestTier(null);
            }
        }

        return $this;
    }
}
