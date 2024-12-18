<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\FuncCall;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setEntityLabelInSingular('Produit')
                ->setEntityLabelInPlural('Produits');
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')->setLabel('Nom')->setHelp('Le nom de votre produit'),
            SlugField::new('slug')->setLabel('Url')->setHelp("l'url de localisation du produit")->setTargetFieldName('name'),
            NumberField::new('price')->setLabel('prix ')->setHelp('Prix Hors Taxes du produit'),
            ChoiceField::new('tva')->setLabel('Taux du TVA du produit')->setChoices([
                '5.5%' => "5.5",
                '10%' => '10',
                '20%' => '20'
            ]),
            AssociationField::new('category','Categorie')->setHelp("Le categorie associes"),
            ImageField::new('image')->setLabel('Image')->setHelp("l'Image de votre produit")->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')->setBasePath('/image')->setUploadDir('/public/image'),
            TextEditorField::new('description')->setLabel('Description')->setHelp('description du produit'),
        ];
    }
    
}
