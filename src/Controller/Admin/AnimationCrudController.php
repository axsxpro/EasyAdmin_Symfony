<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            IdField::new('id'),
            TextField::new('Name'),
            TextField::new('Author'),
            AssociationField::new('AnimationStudio')->setLabel('Animation Studio'),
            AssociationField::new('type')->setLabel('Type')
        ];
    }
    
}
