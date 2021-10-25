<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MessageType;

class MessageController extends AbstractController
{
     # Fonction Index pour Créer, Modifier, et Voir tous les message
    /**
     * @Route("/message", name="message", methods={"GET", "POST"})
     * @Route("/message/maj/{id}", name="maj_message", methods={"GET", "POST"})
     */
    public function index(Message $message = null, Request $request, $majmode = false): Response
    {
        // Si message est null donc on creer une classe message
		if(!$message){
            // Initialisation d'une classe message
            $message = new Message();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request); 
        // variable pour changer le bouton afin de savoir si on modifie ou ajoute des données dans la bdd
        $majmode = $message-> getId() !== null;
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
            if ($form->isSubmitted() && $form->isValid()) {
                // Ajoute les données dans la bdd
                $entityManager->persist($message);
                // Sauvegarde les modifications apporter à la bdd
                $entityManager->flush();
                $majmode = false;
                // redirection vers l url de nom message
                return $this->redirect( $this->generateUrl('message'));
            }
        }
        // Preparation du repository afin de lancer les injections de dépendances
        $repository = $this->getDoctrine()->getRepository(message::class);
        // Rechercher tous les données dans la bdd(message)
        $messages = $repository->findAll();
        // redirection de page vers la page message 
        return $this->render('message/index.html.twig', [
            'MessageForm' => $form->createView(),
            'messages' => $messages,
            'majMode' => $majmode
        ]);
    }
    # La fonction suppr_message pour supprimer un message
    /**
     * @Route("/message/suppr/{id}", name="suppr_message", methods={"GET"})
     */
    public function SupprMessage(Message $message = null): Response
    {  
        // Si message est null donc on creer une classe message
		if(!$message){
            // Initialisation d'une classe message
            $message = new Message();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Prepare la commande pour supprimer le donnée dans la bdd
        $entityManager->remove($message);
        // Sauvegarde les modifications faites dans la bdd
        $entityManager->flush();
        // Redirection vers l'url nommé message
        return $this->redirect( $this->generateUrl('message'));
    }
}
