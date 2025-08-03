<?php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserLoaderInterface;

class UserJWTUserLoader implements JWTUserLoaderInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function loadUserByIdentifier(string $identifier): JWTUserInterface
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $identifier]);
    }
}