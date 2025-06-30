<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;

final class UserController extends AbstractController
{
    #[Route('/user/dashboard', name: 'app_dashboard')]
    public function index(User $user): Response
    {
        $user = $this->getUser();
        $KarmaScore = $user->getKarmaScore();
        $Offenses = $user->getOffenses();
        $KarmaActions = $user->getKarmaActions();

        return $this->render('pages/dashboard.html.twig', [
            'user' => $user,
            'KarmaScore' => $KarmaScore,
            'Offenses' => $Offenses,
            'KarmaActions' => $KarmaActions,
        ]);
    }

    #[Route('/useranalyse', name: 'app_analyse')]
    public function analyse(): Response
    {
        // This method can be used to handle the analysis of posts
        // For now, it just returns a simple response
        return $this->render('pages/analyse.html.twig');
    }
}
