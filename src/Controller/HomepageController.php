<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Topic;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET", "POST"})
     */
    public function index(Topic $topic = null, Request $request): Response
    {
        // Si topic est null donc on creer une classe topic
		if(!$topic){
            // Initialisation d'une classe Topic
            $topic = new Topic();
		}
        // Preparation du repository afin de lancer les injections de dépendances
        $repository = $this->getDoctrine()->getRepository(Topic::class);
        // Rechercher tous les données dans la bdd(topic) dont le plus récents sera ajoutée en bas ordre chornologique des sujets de discussions
        $topics = $repository->findAllOrderByASC_CreationDate();
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'topics' => $topics,
        ]);
    }

}
