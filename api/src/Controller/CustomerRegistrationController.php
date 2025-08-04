<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Tier;
use App\Repository\TierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerRegistrationController extends AbstractController
{
    #[Route('/api/register/customer', name: 'api_register_customer', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, TierRepository $tierRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['otp'], $data['name'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $customer = new Customer();
        $customer->setEmail($data['email']);
        $customer->setName($data['name']);

        $defaultTier = $tierRepository->findOneBy(['name' => 'Bronze'])
            ?? $tierRepository->find(1);

        if (!$defaultTier) {
            return $this->json(['error' => 'Default tier not found'], 500);
        }

        $customer->setTier($defaultTier);
        $customer->setPointsBalance(0);
        $customer->setCreatedAt(new \DateTimeImmutable());
        $customer->setUpdatedAt(new \DateTimeImmutable());

        // Hash OTP like password
        $hashedOtp = $passwordHasher->hashPassword($customer, $data['otp']);
        $customer->setOtpHash($hashedOtp);

        $em->persist($customer);
        $em->flush();

        return $this->json(['message' => 'Customer registered successfully'], 201);
    }
}
