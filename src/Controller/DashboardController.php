<?php

namespace App\Controller;

use App\Entity\ArgentEconomisees;
use App\Entity\Projets;
use App\Entity\Questionnaire;
use App\Form\ArgentEcoType;
use App\Form\ProjetFormType;
use App\Repository\ArgentEconomiseesRepository;
use App\Repository\ProjetRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard/tableau', name: 'app_dashboard')]
    public function index(
        QuestionnaireRepository $questionnaireRepository,
        UserRepository          $userRepository,
        Request                 $request,
        EntityManagerInterface  $entityManager,
    ): Response
    {

        $idUser = $this->getUser()->getId();
        $infomationUser = $questionnaireRepository->findOneBy(['idUser' => $idUser]);
        $salaire = $infomationUser->getSalaire();
        $autreRevenus = $infomationUser->getAutreRevenus();
        $depenses = $infomationUser->getDepenses();
        $methodeEconomie = $infomationUser->getMethodeEconomie();


        $dateMonth = date("m");

        $revenusTotalMois = $salaire + $autreRevenus - $depenses;


        $argentEconomiseAnnee = (($revenusTotalMois * $methodeEconomie) / 100) * (13 - (int)$dateMonth);
        $argentEconomiseAnneeArrondi = round($argentEconomiseAnnee, 2);

        $revenusFinAnnee = $revenusTotalMois * (13 - (int)$dateMonth);


        // ---------------- Formulaire pour ajouter l'argent mis de coté -----------------------------


        $email = $this->getUser()->getUserIdentifier();
        $userConnecte = $userRepository->findOneBy(['email' => $email]);
        $argentEconomisees = $entityManager->getRepository(ArgentEconomisees::class)->findOneBy(['idUser' => $userConnecte->getId()]);


        if (!$argentEconomisees) {
            $argentEconomisees = new ArgentEconomisees();
        }

        $formArgentEco = $this->createForm(ArgentEcoType::class, $argentEconomisees);
        $formArgentEco->handleRequest($request);


        if ($formArgentEco->isSubmitted() && $formArgentEco->isValid()) {


            if (!$argentEconomisees->getId()) {

                $argentEconomisees->setIdUser($userConnecte);
                $argentEconomisees->setArgentTotal($argentEconomisees->getEconomie());
                $entityManager->persist($argentEconomisees);
                $entityManager->flush();

            } else {

                $economieMois = $argentEconomisees->getEconomie();
                $argentTotal = $argentEconomisees->getArgentTotal();

                $argentEconomisees->setEconomie($economieMois);
                $argentEconomisees->setArgentTotal($economieMois + $argentTotal);
                $entityManager->flush();

                return $this->redirectToRoute('app_dashboard');
            }
        }

        $argentEconomieTotal = $argentEconomisees->getArgentTotal();

        return $this->renderForm('/dashboard/Tableau de bord/dashboardTableau.html.twig',
            compact('revenusTotalMois',
                'argentEconomiseAnneeArrondi',
                'argentEconomieTotal',
                'methodeEconomie',
                'revenusFinAnnee',
                'formArgentEco'));
    }


//    -------------------------------------  PROJET -----------------------------------------------------


    #[Route('/dashboard/projets', name: 'app_dashboard_projets')]
    public function projets(
        EntityManagerInterface  $entityManager,
        UserRepository          $userRepository,
        QuestionnaireRepository $questionnaireRepository,
        ProjetRepository        $projetRepository,

    ): Response
    {

//     -----------   Récupération du User connecté : ---------------

        $email = $this->getUser()->getUserIdentifier();
        $userConnecte = $userRepository->findOneBy(['email' => $email]);


        //    -------  Recupération de la ligne du User dans  l'Entity ArgentEonomisées

        $argentEconomisees = $entityManager->getRepository(ArgentEconomisees::class)->findOneBy(['idUser' => $userConnecte->getId()]);


        //   --------  Récupération des infos du questionnaire fait par l'utilisateur :

        $infoQuestionnaireUser = $questionnaireRepository->findOneBy(['idUser' => $userConnecte->getId()]);

        //   --------  Recuperation des infos du projets renseigné par l'utilisateur : -----------


        $infoProjetsUser = $projetRepository->findBy(['id_user' => $userConnecte->getId()]);


        //  --------   Différente donnees du Questionnaires de l'Utilisateurs : -----------


        $salaire = $infoQuestionnaireUser->getSalaire();
        $autreRevenus = $infoQuestionnaireUser->getAutreRevenus();
        $depenses = $infoQuestionnaireUser->getDepenses();
        $methodeEconomie = $infoQuestionnaireUser->getMethodeEconomie();


        $revenusTotalMois = $salaire + $autreRevenus - $depenses;
        $economieMois = ($revenusTotalMois * $methodeEconomie) / 100;

        //  --------   Différente donnees du Projets de l'Utilisateurs : -----------


        foreach ($infoProjetsUser as $projet) {
            $montantProjet = $projet->getMontantProjet();
            $tempsProjet = round(($montantProjet / $economieMois), 0);
            $projet->setTempsProjet($tempsProjet);
            $entityManager->persist($projet);
            $entityManager->flush();
        }


        //   --------  Si le montant des économies est pas null je l'affiche sinon je le met à 0 :  -----------

        if ($argentEconomisees != null) {
            $argentEconomieTotal = $argentEconomisees->getArgentTotal();
        } else
            $argentEconomieTotal = 0;

        return $this->render('dashboard/projet_dashboard/vosProjets.html.twig',
            compact(
                'argentEconomieTotal',
                'infoProjetsUser',
                'argentEconomieTotal',
            )
        );
    }


//    ------------------------------------- AJOUTER PROJET -----------------------------------------------------


    #[Route('/dashboard/projets/ajouter', name: 'app_ajouter_projet')]
    public function addprojet(
        Request                $request,
        UserRepository         $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {

        $email = $this->getUser()->getUserIdentifier();
        $userConnecte = $userRepository->findOneBy(['email' => $email]);


        $projet = new Projets();
        $formProjet = $this->createForm(ProjetFormType::class, $projet);
        $formProjet->handleRequest($request);


        if ($formProjet->isSubmitted() && $formProjet->isValid()) {
            $projet->setIdUser($userConnecte);
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard_projets');
        }

        return $this->renderForm('dashboard/projet_dashboard/ajouter_projet.html.twig',
            compact(
                'formProjet'
            )
        );
    }


    //    ------------------------------------- SUPPRIMER PROJET -----------------------------------------------------


    #[Route('/dashboard/projets/supprimer/{projet}', name: 'app_supprimer_projet')]
    public function deleteprojet(
        Projets                $projet,
        EntityManagerInterface $entityManager
    ): Response
    {
        $entityManager->remove($projet);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard_projets');
    }
}



