<?php
namespace App\DataFixtures\fixtures\providers;

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
        return $this->passwordHasher->hashPassword(new User(), $plainPassword);
    }
}
