<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
class RegistrationController extends AbstractController
{
    #[Route('/reg', name: 'reg')]
    public function reg(Request $request, ManagerRegistry $doctrine): Response
    {
        $regform = $this->createFormBuilder()
        ->add('username',TextType::class,[
            'label' => 'Employee'])
        ->add('password',RepeatedType::class,[
            'type' => PasswordType::class,
            'required' => true,
            'first_options'=> ['label' => 'Password'],
            'second_options'=> ['label' => 'Repeat Password'],
            ])
        ->add('registration', SubmitType::class)
        ->getForm();

        return $this->render('registration/index.html.twig', [
            'regform' => $regform->createView(),
        ]);
    }
}

// class RegistrationController extends AbstractController
// {
//     #[Route('/reg', name: 'reg')]
//     public function reg(Request $request, UserPasswordHasherInterface $passEncoder, ManagerRegistry $doctrine): Response
//     {
//         $regform = $this->createFormBuilder()
//         ->add('username',TextType::class,[
//             'label' => 'Employee'])
//         ->add('password',RepeatedType::class,[
//             'type' => PasswordType::class,
//             'required' => true,
//             'first_options'=> ['label' => 'Password'],
//             'second_options'=> ['label' => 'Repeat Password'],
//             ])
//         ->add('registration', SubmitType::class)
//         ->getForm();

//         // $regform->handleRequest($request);

//         // if($regform->isSubmitted()){
//         //      $input = $regform->getData();
//         //      dump($input);
//         //      $user = new User;
//         //      $user->setUsername($input['username']);

//         //      $user->setPassword(
//         //          $passEncoder->hashPassword($user, $input['password'])
//         //      );

//         //     $em = $doctrine->getManager();
//         //     $em->persist($user);
//         //     $em->flush();
//         //     return $this->redirect($this->generateUrl('app_home'));

//         //     }
//         return $this->render('registration/index.html.twig', [
//             'regform' => $regform->createView(),
//         ]);
//     }
// }
