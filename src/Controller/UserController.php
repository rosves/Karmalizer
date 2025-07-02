<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Offense;
use App\Form\AnalyseForm;
use App\Service\SeverityAnalyzer;
use App\Repository\OffenseRepository;



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

    #[Route('/user/analyse', name: 'app_analyse')]
    public function analyse(Request $request, User $user, SeverityAnalyzer $severityAnalyzer, Offense $offense, EntityManagerInterface $em, RedemptionMissionRepository $RedemptionMission): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AnalyseForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $score = $severityAnalyzer->analyze($form->get('AnalysePost')->getData());

            if(!$score) {
                $this->addFlash('error', 'Aucun score n\'a été calculé. Veuillez réessayer.');
            }

            $offense = new Offense();
            $Missions = $RedemptionMission->findBy(['severity_min' => $score]);
            $offense->setContent($Post)
                    ->setSeverity($score)
                    ->setPlatform($form->get('Plateforme')->getData())
                    ->setUserId($user)
                    ->setRedemptionMissions($Missions);
            $em->persist($offense);
            $em->flush();

            return $this->redirectToRoute('app_offense_detail', ['id' => $offense->getId()]);
        }

        return $this->render('pages/analyse.html.twig', [
            'AnalyseForm' => $form,
        ]);

    }

    #[Route('/user/offenses{id}', name: 'app_offense_detail')]
    public function offenseDetail($id,OffenseRepository $Offense): Response {
        $offense = $Offense->find($id);

        if (!$offense) {
            throw $this->createNotFoundException('Offense not found');
        }

        return $this->render('pages/offense_detail.html.twig', [
            'offense' => $offense,
            'missions' => $Missions,
        ]);
    }

}
