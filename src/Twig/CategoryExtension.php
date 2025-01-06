<?php

namespace App\Twig;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension implements GlobalsInterface
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    // public function getFunctions()
    // {
    //     return [
    //         new TwigFunction('allCategory' , [$this, 'allCategory']),
    //     ];
    // }

    public function getGlobals(): Array {
        $category = $this->em->getRepository(Category::class)->findAll();

        return [
            'AllCategory' => $category,
        ];
    }
}