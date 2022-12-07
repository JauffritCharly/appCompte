<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request                     $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface      $entityManager): Response
    {
        $user = new User();
        $formInscription = $this->createForm(RegistrationFormType::class, $user);
        $formInscription->handleRequest($request);

        if ($formInscription->isSubmitted() && $formInscription->isValid()) {

            $brochureFile = $formInscription->get('imageCompte')->getData();
            // this condition is needed because the 'brochure' field is not required

            // so the file must be processed only when a file is uploaded

            if ($brochureFile) {

                // this is needed to safely include the file name as part of the URL
                $newFilename = md5(uniqid()) . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                $brochureFile->move(
                    $this->getParameter('user_directory'),
                    $newFilename);


                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImageCompte($newFilename);
            }

            // Hash le mot de passe avant d'aller en BDD
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formInscription->get('plainPassword')->getData()
                )
            );

            $user->setQuestionnaireFait(0);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('/Inscription/register.html.twig',
            compact('formInscription'));
    }
}
