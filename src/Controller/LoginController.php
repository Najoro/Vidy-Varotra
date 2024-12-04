<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'user_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //error
        $error = $authenticationUtils->getLastAuthenticationError();

        //last Name
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'error'=> $error,
            'last_username' => $lastUsername,
        ]);
    }

    
    #[Route('/logout', name: "user_logout")]
    public function logout(){

        return $this->redirectToRoute('user_login');
    }
}
