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
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        #Initialisation variable request   
        $request = Request::createFromGlobals();
        #Choper la variable GET age et mettre valeur par défaut 0
        $age = $request->query->get('age', 0);
        # retourne la page twig et on prend la variable PHP age mis en relation avec variable twig age
        return $this->render('test/test.html.twig', [
            'age' => $age,
        ]);
    }
}
