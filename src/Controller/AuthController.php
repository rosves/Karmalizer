<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\KarmaScore;
use App\Form\RegistrationForm;

class AuthController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('/');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('/');
        }

        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // On set les propriétés de l'utilisateur
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // On initialise le karmaBalance et le karmaScore
            $user->setKarmaBalance(200);
            $KarmaScore = (new KarmaScore())->setScore(0)->setLevel(1);
            $user->setKarmaScore($KarmaScore);

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('auth/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
