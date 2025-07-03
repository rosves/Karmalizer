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
use App\Form\SubmitKarmaActionForm;
use App\Service\SeverityAnalyzer;
use App\Repository\OffenseRepository;
use App\Repository\KarmaActionRepository;
use App\Repository\RedemptionMissionRepository;
use App\Repository\UserRepository;



final class UserController extends AbstractController
{

    #[Route('/user/dashboard', name: 'app_dashboard')]
    public function index(User $user, KarmaActionRepository $KarmaActionRepository): Response
    {
        $user = $this->getUser();
        $KarmaScore = $user->getKarmaScore();
        $Offenses = $user->getOffenses();
        $KarmaActions = $KarmaActionRepository->findBy(['user_id' => $user, 'Type'=> 'Pending']);

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
            $Post = $form->get('AnalysePost')->getData();
            $score = $severityAnalyzer->analyze($Post);

            if(!$score) {
                $this->addFlash('error', 'Aucun score n\'a été calculé. Veuillez réessayer.');
            }

            $offense = new Offense();
            $Missions = $RedemptionMission->findBy(['severity_min' => $score]);
            $offense->setContent($Post)
                    ->setSeverity($score)
                    ->setPlatform($form->get('Plateforme')->getData())
                    ->setUserId($user);
            foreach ($Missions as $mission) {
                $offense->addRedemptionMission($mission);
            }
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
        $user = $this->getUser();

        if (!$offense) {
            throw $this->createNotFoundException('Offense not found');
        }

        if ($offense->getUserId() !== $user && !$this->isGranted('ROLE_MODERATOR', 'ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas accéder à cette offense');
        }

        $KarmaActions = $offense->getKarmaActions();
        $Missions = $offense->getRedemptionMissions();

        $karmaActionsUser = $KarmaActions->filter(function($ka) use ($user) {
            return $ka->getUserId() === $user;
        });

        $Rewards = [];
        foreach ($Missions as $mission) {
            foreach ($mission->getRewards() as $reward) {
                $Rewards[] = $reward;
            }
        }

        return $this->render('pages/offense_detail.html.twig', [
            'offense' => $offense,
            'missions' => $Missions,
            'karmaActions' => $karmaActionsUser,
        ]);
    }

    #[Route('/user/KarmaActions/{id}', name: 'app_karmaAction_detail')]
    public function KarmaActionDetail($id, Request $request): Response {

        $form = $this->createForm(SubmitKarmaActionForm::class);
        $form->handleRequest($request);

      return $this->render('pages/mission_detail.html.twig', [
            'KarmaAction' => $id,
            'form' => $form,
        ]);
    }

    #[Route('/user/rewards', name: 'app_rewards')]
    public function rewards(): Response {
        $user = $this->getUser();
        $userRewards = $user->getRewards();

        if (!$userRewards) {
            $this->addFlash('info', 'Aucune récompense trouvée.');
        }

        return $this->render('pages/reward.html.twig', [
            'rewards' => $userRewards,
        ]);
    }

    #[Route('/user/ranking', name: 'app_ranking')]
    public function ranking(userRepository $user): Response {
        $users = $user->findUsersByKarmaScoreDesc(10);

        return $this->render('pages/ranking.html.twig', [
            'users' => $users,
        ]);
    }

}
