<?php

namespace App\Controller\Admin;

use App\Entity\RedemptionMission;
use App\Entity\Reward;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->container->get(AdminUrlGenerator::class)
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Karmalizer Admin')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Gestion');

        yield MenuItem::linkToCrud('Utilisateurs & Rôles', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Missions karmiques', 'fa fa-flag', RedemptionMission::class);
        yield MenuItem::linkToCrud('Récompenses', 'fas fa-trophy', Reward::class);

        yield MenuItem::linkToLogout('Déconnexion', 'fa fa-sign-out-alt');
    }
}
