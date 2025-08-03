<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 20, unique: true, nullable: true)]
    private ?string $phone = null;


    #[ORM\Column(length: 255, unique: true)]
    private ?string $qrCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $otpHash = null;

    #[ORM\Column]
    private ?int $pointsBalance = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tier $tier = null;

    /**
     * @var Collection<int, Redemption>
     */
    #[ORM\OneToMany(targetEntity: Redemption::class, mappedBy: 'customer')]
    private Collection $redemptions;

    /**
     * @var Collection<int, CustomerPoint>
     */
    #[ORM\OneToMany(targetEntity: CustomerPoint::class, mappedBy: 'customer')]
    private Collection $customerPoints;

    public function __construct()
    {
        $this->redemptions = new ArrayCollection();
        $this->customerPoints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): static
    {
        $this->qrCode = $qrCode;

        return $this;
    }

    public function getOtpHash(): ?string
    {
        return $this->otpHash;
    }

    public function setOtpHash(?string $otpHash): static
    {
        $this->otpHash = $otpHash;

        return $this;
    }

    public function getPointsBalance(): ?int
    {
        return $this->pointsBalance;
    }

    public function setPointsBalance(int $pointsBalance): static
    {
        $this->pointsBalance = $pointsBalance;

        return $this;
    }

    public function getTier(): ?Tier
    {
        return $this->tier;
    }

    public function setTier(?Tier $tier): static
    {
        $this->tier = $tier;

        return $this;
    }

    /**
     * @return Collection<int, Redemption>
     */
    public function getRedemptions(): Collection
    {
        return $this->redemptions;
    }

    public function addRedemption(Redemption $redemption): static
    {
        if (!$this->redemptions->contains($redemption)) {
            $this->redemptions->add($redemption);
            $redemption->setCustomer($this);
        }

        return $this;
    }

    public function removeRedemption(Redemption $redemption): static
    {
        if ($this->redemptions->removeElement($redemption)) {
            // set the owning side to null (unless already changed)
            if ($redemption->getCustomer() === $this) {
                $redemption->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CustomerPoint>
     */
    public function getCustomerPoints(): Collection
    {
        return $this->customerPoints;
    }

    public function addCustomerPoint(CustomerPoint $customerPoint): static
    {
        if (!$this->customerPoints->contains($customerPoint)) {
            $this->customerPoints->add($customerPoint);
            $customerPoint->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomerPoint(CustomerPoint $customerPoint): static
    {
        if ($this->customerPoints->removeElement($customerPoint)) {
            // set the owning side to null (unless already changed)
            if ($customerPoint->getCustomer() === $this) {
                $customerPoint->setCustomer(null);
            }
        }

        return $this;
    }
}
