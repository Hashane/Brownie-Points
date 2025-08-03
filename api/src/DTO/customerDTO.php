<?php
namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
class customerDTO
{
    #[Assert\NotBlank(groups: ['create'])]
    public string $name;

    #[Assert\Email(groups: ['create', 'update'])]
    public string $email;

    #[Assert\NotBlank(groups: ['create'])]
    public string $qrCode;

    #[Assert\GreaterThanOrEqual(0, groups: ['create', 'update'])]
    public int $pointsBalance;

    #[Assert\NotBlank(groups: ['create'])]
    public int $tierId;

    public ?string $phone = null;
    public ?string $otpHash = null;

}