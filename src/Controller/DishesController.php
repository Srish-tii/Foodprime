<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Form\DishType;
use App\Repository\DishesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dishes', name: 'dishes.')]
class DishesController extends AbstractController
{
    #[Route('/', name: 'edit')]
    // /**
    //  * @Route("/dishes", name="dishes")
    //  */
    public function index(DishesRepository $ds): Response
    {
        $dishes =$ds->findAll();

        return $this->render('dishes/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(Request $request, ManagerRegistry $doctrine){
        $dishes = new Dishes();
        $form = $this->createForm(DishType::class, $dishes);
        $form->handleRequest($request);
        if($form->isSubmitted()){
           $em = $doctrine -> getManager();
           $em->persist($dishes);
           $em->flush();

           return $this->redirect($this->generateUrl('dishes.edit'));
        }

        

        return $this->render('dishes/create.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, DishesRepository $ds, ManagerRegistry $doctrine){
        $em = $doctrine -> getManager();
        $dishes=$ds->find($id);
        $em->remove($dishes);
        $em->flush();

        $this->addFlash('success', 'Dish was deleted successfully');
        return $this->redirect($this->generateUrl('dishes.edit'));
    }
}
