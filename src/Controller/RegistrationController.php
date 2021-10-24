<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register" , methods={"GET", "POST"})
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        // Initialisation d'une classe User
        $user = new User();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        // Si le formulaire est valide on va encoder d'abord le mdp
        if ($form->isSubmitted() && $form->isValid()) {
            // encodage du mot de passe
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            // Ajoute les données dans la bdd
            $entityManager->persist($user);
            // Sauvegarde les modifications apporter à la bdd
            $entityManager->flush();
            // affiche un short message
            $this->addFlash('message','Utilisateur créer avec succès');
            // retourne sur la page d'accueil
            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
