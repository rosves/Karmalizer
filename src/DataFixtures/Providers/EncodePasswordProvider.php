<?php
namespace App\DataFixtures\Providers;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EncodePasswordProvider
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function encodePassword(string $plainPassword): string
    {
        $user = new User(); 
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }
}
