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
        
    /**
     * __construct 
     *
     * @param  mixed $em
     * @return void
     */
    public function __construct(private EntityManagerInterface $em) {
        $this->em = $em;
    }
     

    #[Route('/inscription', name: 'user_register')]    
    /**
     * inscription => creer une nouvelle utilisateur
     *
     * @param  mixed $request
     * @param  mixed $em
     * @return Response : twig [
     *      form => formulaire de remplissage
     * ]
     */
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
    /**
     * userSave : Sauvegarder le formulaire de l'inscription pour une nouvelle utilisateur
     *
     * @param  mixed $request
     * @return void
     */
    public function userSave(Request $request, EntityManagerInterface $entityManagerInterface) {
        $user = new User();

        $form = $this->createForm(RegisterUserType::class , $user , [
            'action' => $this->generateUrl("user_save")
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $entityManagerInterface->persist($user);
            $entityManagerInterface->   flush();
            
        }   
        
        return $this->render('register/register.html.twig', [
            "RegisterForm" => $form->createView()
        ]);
    }
}
