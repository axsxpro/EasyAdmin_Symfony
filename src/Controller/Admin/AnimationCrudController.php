<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animation::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('Name'),
            DateField::new('releaseDate')->onlyOnForms(), // masqué sur le dashboard sauf la page edit et create
            TextField::new('Author'),
            AssociationField::new('AnimationStudio')->setLabel('Animation Studio'),
            AssociationField::new('type')->setLabel('Type')
        ];
    }
    
}
