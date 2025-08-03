<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TierRepository::class)]
#[ApiResource]
class Tier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $minPointsRequired = null;

    #[ORM\Column]
    private ?int $maxPointsAllowed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $badgeIconUrl = null;

    #[ORM\Column(nullable: true)]
    private ?array $perks = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Customer>
     */
    #[ORM\OneToMany(targetEntity: Customer::class, mappedBy: 'tier')]
    private Collection $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

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

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
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
}
