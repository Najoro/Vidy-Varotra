<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    
    public function __construct(private EntityManagerInterface $em) {
        $this->em = $em;
    }
     
    #[Route('/account', name: 'account_index')]
    public function index(): Response
    {
        return $this->render('account/account.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/change-password', name: 'user_change_password')]
    public function changePassWord(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user, [
            'user' => $user,
            'hasher' => $hasher,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->addFlash('success', 'Votre a ete bien Modifier');
            $this->em->flush();
            
            return $this->redirectToRoute('user_login');
        }

        return $this->render('account/change-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
