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
    # Fonction Index pour Créer, Modifier, et Voir tous les topics
    /**
     * @Route("/topic", name="topic", methods={"GET", "POST"})
     * @Route("/topic/maj/{id}", name="maj_topic", methods={"GET", "POST"})
     */
    public function index(Topic $topic = null, Request $request, $majmode = false): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request); 
        // variable pour changer le bouton afin de savoir si on modifie ou ajoute des données dans la bdd
        $majmode = $topic-> getId() !== null;
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
            // Si le formulaire est valide on va encoder d'abord le mdp
            if ($form->isSubmitted() && $form->isValid()) {
                // Ajoute les données dans la bdd
                $entityManager->persist($topic);
                // Sauvegarde les modifications apporter à la bdd
                $entityManager->flush();
                //$topic = null;
                $majmode = false;
                // redirection vers l url de nom topic
                return $this->redirect( $this->generateUrl('topic'));
            }
        }
        // Preparation du repository afin de lancer les injections de dépendances
        $repository = $this->getDoctrine()->getRepository(Topic::class);
        // Rechercher tous les données dans la bdd(topic)
        $topics = $repository->findAll();
        // redirection de page vers la page topic 
        return $this->render('topic/index.html.twig', [
            'TopicForm' => $form->createView(),
            'topics' => $topics,
            'majMode' => $majmode
        ]);
    }
    # La fonction suppr_topic pour supprimer un topic
    /**
     * @Route("/topic/suppr/{id}", name="suppr_topic")
     */
    public function suppr_topic(Topic $topic = null): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Prepare la commande pour supprimer le donnée dans la bdd
        $entityManager->remove($topic);
        // Sauvegarde les modifications faites dans la bdd
        $entityManager->flush();
        // Redirection vers l'url nommé topic
        return $this->redirect( $this->generateUrl('topic'));
    }
    /**
     * @Route("/topic/voir/{id}", name="voir_topic")
     */
    public function see_one_topic(Topic $topic = null): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        //dd($topic->getId());
        //dd($topic->getMessages());
        //dd($user_id);
        return $this->render('base/one_topic.html.twig', [
            'controller_name' => 'HomepageController',
            'topic' => $topic,
        ]);
    }
}
