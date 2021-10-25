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

    /**
     * @Route("/user", name="user", methods={"GET", "POST"})
     * @Route("/user/maj/{id}", name="maj_user", methods={"GET", "POST"})
     */
    public function users(User $user = null, Request $request,UserPasswordHasherInterface $userPasswordHasherInterface, $majmode = false): Response
    {
        // Si user est null donc on creer une classe user
		if(!$user){
            // Initialisation d'une classe user
            $user = new User();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request); 
        // variable pour changer le bouton afin de savoir si on modifie ou ajoute des données dans la bdd
        $majmode = $user-> getId() !== null;
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
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
                $majmode = false;
                // retourne sur la page d'accueil
                return $this->redirectToRoute('user');
            }
        }
        // Preparation du repository afin de lancer les injections de dépendances
        $repository = $this->getDoctrine()->getRepository(User::class);
        // Rechercher tous les données dans la bdd(user)
        $users = $repository->findAll();
        // redirection de page vers la page user 
        return $this->render('user/index.html.twig', [
            'UserForm' => $form->createView(),
            'users' => $users,
            'majMode' => $majmode
        ]);
    }

    # La fonction suppr_user pour supprimer un user
    /**
     * @Route("/user/suppr/{id}", name="suppr_user", methods={"GET"})
     */
    public function suppr_user(User $user = null): Response
    {  
        // Si user est null donc on creer une classe user
		if(!$user){
            // Initialisation d'une classe user
            $user = new user();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Prepare la commande pour supprimer le donnée dans la bdd
        $entityManager->remove($user);
        // Sauvegarde les modifications faites dans la bdd
        $entityManager->flush();
        // Redirection vers l'url nommé user
        return $this->redirect( $this->generateUrl('user'));
    }
}
