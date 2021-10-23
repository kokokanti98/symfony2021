<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
# namespace pour utiliser Request
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
    /**
     * @Route("/test", name="test1" , methods={"GET", "POST"})
     */
    public function testGET1(Request $request): Response
    {
        #Initialisation variable request   
        #$request = Request::createFromGlobals();
        #Choper la variable GET age et mettre valeur par défaut 0
        $age = $request->query->get('age', 0);
        # retourne la page twig et on prend la variable PHP age mis en relation avec variable twig age
        return $this->render('test/test.html.twig', [
            'age' => $age,
        ]);
    }
    /**
     * @Route("/test/{age}", name="test2" , methods={"GET", "POST"})
     */
    public function testGET2(Request $request): Response
    {
        #Initialisation variable request   
        #$request = Request::createFromGlobals();
        #Choper la variable GET age et mettre valeur par défaut 0
        $age = $request->attributes->get('age', 0);
        # retourne la page twig et on prend la variable PHP age mis en relation avec variable twig age
        return $this->render('test/test.html.twig', [
            'age' => $age,
        ]);
    }
    /**
     * @Route("/onetopic", name="onetopic")
     */
    public function onetopic(): Response
    {
        return $this->render('base/one_topic.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

}
