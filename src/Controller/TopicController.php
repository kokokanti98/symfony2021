<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TopicType;
use App\Form\TopicTypeUser;
use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageTypeSend;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TopicController extends AbstractController
{
    # Fonction Index pour Créer, Modifier, et Voir tous les topics
    /**
     * @Route("/topic", name="topic", methods={"GET", "POST"})
     * @Route("/topic/maj/{id}", name="maj_topic", methods={"GET", "POST"})
     */
    public function index(Topic $topic = null, Request $request, $majmode = false, User $user = null, AuthenticationUtils $authenticationUtils): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // Si user est null donc on creer une classe user
		if(!$user){
            // Initialisation d'une classe user
            $user = new User();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaire du mode utilisateur à partir de la classe
        $form_user = $this->createForm(TopicTypeUser::class, $topic);
        $form_user->handleRequest($request); 
        // Création d'un formulaire du mode administrateur à partir de la classe
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request); 
        // variable pour changer le bouton afin de savoir si on modifie ou ajoute des données dans la bdd
        $majmode = $topic-> getId() !== null;
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
            if ($form->isSubmitted() && $form->isValid()) {
                //Dans le cas où y a pas de champ auteur et champ de date de creation dans le formulaire/ form utilisateur simple
                if($topic->getAuthor() == null && $topic->getCreationDate() == null){
                    // permet de récuperer le email du dernier utilisateur connecté
                    $lastUsername = $authenticationUtils->getLastUsername();
                    // Preparation du repository afin de lancer les injections de dépendances
                    $repository = $this->getDoctrine()->getRepository(User::class);
                    // Rechercher l'utilisateur dans la bdd
                    $user = $repository->findOneBy(array('email' => $lastUsername));
                    // Set les valeurs de l'auteur connecté sur le sujet de discussion
                    $topic->setAuthor($user);
                    // On va prendre l'heure et la date maintenant
                    $datenow = new \DateTime();
                    // Set la date de creation du sujet de discussion
                    $topic->setCreationDate($datenow);
                }
                // Ajoute les données dans la bdd
                $entityManager->persist($topic);
                // Sauvegarde les modifications apporter à la bdd
                $entityManager->flush();
                $majmode = false;
                // redirection vers l url de nom topic
                return $this->redirect( $this->generateUrl('topic'));
            }
        }
        // Preparation du repository afin de lancer les injections de dépendances
        $repository = $this->getDoctrine()->getRepository(Topic::class);
        // Rechercher tous les données dans la bdd(topic)
        $topics = $repository->findAllOrderByASC_CreationDate();
        // redirection de page vers la page topic 
        return $this->render('topic/index.html.twig', [
            'TopicForm' => $form->createView(),
            'TopicUserForm' => $form_user->createView(),
            'topics' => $topics,
            'majMode' => $majmode
        ]);
    }
    # La fonction suppr_topic pour supprimer un topic
    /**
     * @Route("/topic/suppr/{id}", name="suppr_topic", methods={"GET"})
     */
    public function SupprTopic(Topic $topic = null): Response
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
    public function SeeOneTopic(Topic $topic = null, Message $message = null, Request $request, User $user = null, AuthenticationUtils $authenticationUtils): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // Si message est null donc on creer une classe message
		if(!$message){
            // Initialisation d'une classe message
            $message = new Message();
		}
        // Si user est null donc on creer une classe user
		if(!$user){
            // Initialisation d'une classe user
            $user = new User();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaiire à partir de la classe
        $form = $this->createForm(MessageTypeSend::class, $message);
        $form->handleRequest($request); 
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
            if ($form->isSubmitted() && $form->isValid()) {
                // permet de récuperer le email du dernier utilisateur connecté
                 $lastUsername = $authenticationUtils->getLastUsername();
                // Preparation du repository afin de lancer les injections de dépendances
                $repository = $this->getDoctrine()->getRepository(User::class);
                // Rechercher l'utilisateur dans la bdd
                $user = $repository->findOneBy(array('email' => $lastUsername));
                // Set les valeurs d auteur et sujet de discussion de message
                $message->setAuthor($user);
                $message->setTopic($topic);
                // On va prendre l'heure et la date maintenant
                $datenow = new \DateTime();
                // Set la date de l'envoi du message
                $message->setCreationDate($datenow);
                // Ajoute du message dans la bdd
                $entityManager->persist($message);
                // Sauvegarde les modifications apporter à la bdd
                $entityManager->flush();
                return $this->render('base/one_topic.html.twig', [
                    'controller_name' => 'HomepageController',
                    'topic' => $topic,
                    'MessageForm' => $form->createView(),
                ]);
            }
        }
        return $this->render('base/one_topic.html.twig', [
            'controller_name' => 'HomepageController',
            'topic' => $topic,
            'MessageForm' => $form->createView(),
        ]);
    }
    # Fonction Index pour Créer les topics en utilisateur simple
    /**
     * @Route("/topic/create", name="create_topic", methods={"GET", "POST"})
     */
    public function create(Topic $topic = null, Request $request, User $user = null, AuthenticationUtils $authenticationUtils): Response
    {  
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // Si user est null donc on creer une classe user
		if(!$user){
            // Initialisation d'une classe user
            $user = new User();
		}
        // initialisation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        // Création d'un formulaire du mode utilisateur à partir de la classe
        $form_user = $this->createForm(TopicTypeUser::class, $topic);
        $form_user->handleRequest($request); 
        // Dans le cas ou on notre method sera un post
        if ($request->isMethod('post')) {
            if ($form_user->isSubmitted() && $form_user->isValid()) {
                //Dans le cas où y a pas de champ auteur et champ de date de creation dans le formulaire/ form utilisateur simple
                if($topic->getAuthor() == null && $topic->getCreationDate() == null){
                    // permet de récuperer le email du dernier utilisateur connecté
                    $lastUsername = $authenticationUtils->getLastUsername();
                    // Preparation du repository afin de lancer les injections de dépendances
                    $repository = $this->getDoctrine()->getRepository(User::class);
                    // Rechercher l'utilisateur dans la bdd
                    $user = $repository->findOneBy(array('email' => $lastUsername));
                    // Set les valeurs de l'auteur connecté sur le sujet de discussion
                    $topic->setAuthor($user);
                    // On va prendre l'heure et la date maintenant
                    $datenow = new \DateTime();
                    // Set la date de creation du sujet de discussion
                    $topic->setCreationDate($datenow);
                }
                // Ajoute les données dans la bdd
                $entityManager->persist($topic);
                // Sauvegarde les modifications apporter à la bdd
                $entityManager->flush();
                // redirection vers l url de nom topic
                return $this->redirect( $this->generateUrl('homepage'));
            }
        }
        // redirection de page vers la page topic 
        return $this->render('topic/create.html.twig', [
            'TopicUserForm' => $form_user->createView(),
        ]);
    }
}
