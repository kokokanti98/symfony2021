<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TopicType;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic", name="topic", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {   
        // Initialisation d'une classe Topic
        $topic = new Topic();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        // Si le formulaire est valide on va encoder d'abord le mdp
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // Ajoute les données dans la bdd
            $entityManager->persist($topic);
            // Sauvegarde les modifications apporter à la bdd
            $entityManager->flush();
            // retourne sur la page nommée topic 
            return $this->redirectToRoute('topic');
        }
        return $this->render('topic/index.html.twig', [
            'TopicForm' => $form->createView(),
        ]);
    }
}
