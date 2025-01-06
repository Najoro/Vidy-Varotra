<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;        
    }
    
    #[Route('/category/{slug}', name: 'category_index')]
    public function index(String $slug): Response
    {
        $categoryRep = $this->em->getRepository(Category::class);
        $category = $categoryRep->findOneBySlug($slug);
        
        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
