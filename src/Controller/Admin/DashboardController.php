<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\RedemptionMission;
use App\Entity\Reward;
use App\Entity\User;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();
        // Si tu veux une page custom :
        return $this->render('pages/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Karmalizer');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Missions', 'fas fa-flag', RedemptionMission::class);

        yield MenuItem::linkToCrud('Récompenses', 'fas fa-trophy', Reward::class);

        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
    }
}
