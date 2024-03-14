<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController {


    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        //affiche les champs dans le Dashboard
        $fields = [

            IdField::new('id'),
            TextField::new('Name'),
            TextField::new('Firstname'),
            EmailField::new('Email'),
        ];

        // si la page actuelle n'est pas celle de création d'un nouvel utilisateur
        if (Crud::PAGE_NEW !== $pageName) {

           // alors affichage du champs épisode 
            $fields[] = CollectionField::new('Episodes')->setLabel('Episode(s) seen');
        }

        // si la page actuelle est celle de création d'un nouvel utilisateur
        if (Crud::PAGE_NEW === $pageName) {

            // alors ajouter le champ de mot de passe
            $fields[] = TextField::new('password')
                ->setLabel('Password')
                ->setFormTypeOption('mapped', false) // la valeur saisie dans ce champ ne sera pas automatiquement associée à une propriété de l'entité User lors de la soumission du formulaire. Cela est nécessaire car le mot de passe doit être traité différemment et hashé avant d'être stocké dans la base de données.
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password']); // empêche le navigateur de proposer des suggestions de mots de passe

        }

        return $fields;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Si l'entité est de type User et le mot de passe n'est pas vide
        if ($entityInstance instanceof User && !empty($entityInstance->getPassword())) {
            // Hasher le mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPassword());
            // Définir le mot de passe hashé sur l'entité
            $entityInstance->setPassword($hashedPassword);
        }
        // Persister l'entité
        parent::persistEntity($entityManager, $entityInstance);
    }


}