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
    #[Route('/inscription', name: 'app_register')]
    public function inscription(Request $request , EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class , $user);

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em->persist($user);
            $em->flush();
        }


        return $this->render('register/register.html.twig', [
            "RegisterForm" => $form->createView()
        ]);
    }
}
