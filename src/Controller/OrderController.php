<?php

namespace App\Controller;

use App\Entity\Dishes;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {

        $order = $orderRepository->findBy(
            ['new_table'=>'new_table1']
        );
        return $this->render('order/index.html.twig', [
            'orders' => $order,
        ]);
    }
    #[Route('/new_order/{id}', name: 'new_order')]
    public function new_order(Dishes $dishes, ManagerRegistry $doctrine){
        $order=new Order();
        $order->setNewTable("new_table");
        $order->setName($dishes->getName());
        // $order->setOrderNumber($dishes->getOrderNumber());
        $order->setPrice($dishes->getPrice());
        $order->setStatus("open");

        $em = $doctrine -> getManager();
        $em->persist($order);
        $em->flush();

        $this->addFlash('Order', $order->getName().'has been added to the cart!');
        return $this->redirect($this->generateUrl('app_menu'));
        
    }

    
    #[Route('/status/{id},{status}', name: 'status')]
    public function status($id, $status, ManagerRegistry $doctrine)
    {
        
        $em = $doctrine -> getManager();
        $order = $em->getRepository(Order::class)->find($id);

        $order->setStatus($status);
        $em->flush();

        return $this->redirect($this->generateUrl('order'));
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function entfernen($id, OrderRepository $or, ManagerRegistry $doctrine)
    {
        $em = $doctrine -> getManager();
        $order = $or->find($id);
        $em->remove($order);
        $em->flush();

        return $this->redirect($this->generateUrl('order'));
    }
}
