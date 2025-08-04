<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserRegistrationController extends AbstractController
{
    #[Route('/api/register/user', name: 'api_register_user', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Basic validation, expand as needed
        if (!isset($data['email'], $data['password'], $data['name'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setRole('ROLE_USER');
        $user->setActive(true);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTimeImmutable());

        // Hash password
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPasswordHash($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'User registered successfully'], 201);
    }
}

