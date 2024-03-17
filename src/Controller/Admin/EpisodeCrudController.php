<?php

namespace App\Controller\Admin;

use App\Entity\Episode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class EpisodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Episode::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('synopsis')->onlyOnForms(),
            NumberField::new('numberEpisode')->setLabel('N° episode'),
            TimeField::new('duration')->onlyOnForms(),
            DateField::new('broadcastingDate')->onlyOnForms(),
            NumberField::new('numberSeason')->setLabel('N° season'),
            AssociationField::new('animation')->setLabel('Animation Name'), // utilisé lorsque l'entité possède une relation vers une seule autre entité

        ];
    }
    
}
