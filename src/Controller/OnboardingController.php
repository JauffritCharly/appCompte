<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireFormType;
use App\Repository\QuestionnaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OnboardingController extends AbstractController
{
    #[Route('/Questionnaire', name: 'app_onboarding')]
    #[IsGranted ('ROLE_USER')]
    public function formulaireQuestion(
        Request                 $request,
        EntityManagerInterface  $entityManager,
        UserRepository          $userRepository,
        QuestionnaireRepository $questionnaireRepository
    ): Response
    {

        $idUser = $this->getUser()->getId();
        $user = $userRepository->findOneBy(['id' => $idUser]);
        $idUserQuestionnaire = $questionnaireRepository->findOneBy(['idUser' => $idUser]);

        if ($user->isQuestionnaireFait()) {
            return $this->redirectToRoute('app_dashboard');
        } else {

            $questionnaire = new Questionnaire();
            $questionnaireForm = $this->createForm(QuestionnaireFormType::class, $questionnaire);

            //-----  Mon formulaire va aller traiter la requete : --------

            $questionnaireForm->handleRequest($request);

            $userConnecte = $userRepository->findOneBy(['id' => $idUser]);
            $questionnaire->setIdUser($userConnecte);

            //Est ce que le formulaire a été soumis :

            //si oui on va ajouter en BDD, rediriger vers le tableau de bord :
            if ($questionnaireForm->isSubmitted() && $questionnaireForm->isValid()) {

                $questionnaireFait = $user->setQuestionnaireFait(1);
                $entityManager->persist($questionnaireFait);
                $entityManager->persist($questionnaire);
                $entityManager->flush();

                return $this->redirectToRoute('app_dashboard');
            }

            //sinon on réaffiche notre formulaire vide :

            return $this->render('onboarding/onboarding.html.twig', [
                'controller_name' => 'OnboardingController',
                'questonnaireForm' => $questionnaireForm->createView(),
            ]);
        }
    }
}
