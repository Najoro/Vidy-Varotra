<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em) {
        $this->em = $em;
    }
     

    #[Route('/inscription', name: 'user_register')]    
    public function inscription(): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class , $user, [
            'action' => $this->generateUrl("user_save")
        ]);
        
        return $this->render('register/register.html.twig', [
            "RegisterForm" => $form->createView()
        ]);
    }


    #[Route("/inscription/save" , name : "user_save")]    
    public function userSave(Request $request) {
        $user = new User();

        $form = $this->createForm(RegisterUserType::class, $user, [
            'action' => $this->generateUrl("user_save")
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash("success" , "Ajout d'un user avec Success");
            return $this->redirectToRoute('home');
        }   
        
        return $this->render('register/register.html.twig', [
            "RegisterForm" => $form->createView()
        ]);
    }
}
