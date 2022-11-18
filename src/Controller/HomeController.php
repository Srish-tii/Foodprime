<?php

namespace App\Controller;

use App\Repository\DishesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // #[Route('/', name: 'app_home')]
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }
    /**
     * @Route("/", name="home")
     */
    public function index(DishesRepository $ds) 
    {
        $dishes = $ds->findAll();
        $rndm=array_rand($dishes, 2);
       
        return $this->render('home/index.html.twig', [
            'dishes1'=>dump($dishes[$rndm[0]]),
            'dishes2'=>dump($dishes[$rndm[1]]),
        ]);
    }
    // #[Route('/start', name: 'start')]
    // public function start(): Response
    // {
    //     return $this->render('home/start.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }
}
