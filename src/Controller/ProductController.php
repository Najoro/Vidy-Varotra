<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;        
    }

    #[Route('/product/{slug}', name: 'product_index')]
    public function index(string $slug): Response
    {
        $productRep = $this->em->getRepository(Product::class);
        $product = $productRep->findOneBySlug($slug);

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
