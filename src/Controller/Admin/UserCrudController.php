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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserCrudController extends AbstractCrudController
{

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

            //->hideOnForm() : masquer le champs dans la page modification et creation
            IdField::new('id')->hideOnForm()->setFormTypeOption('disabled', true)->setSortable(false), // le hidden form permet de cacher le champs dans n'importe quel formulaire (creation ou modification)
            
            TextField::new('Name')->hideWhenUpdating()
            ->setFormTypeOption('constraints', [
                new NotBlank(['message' => 'Please enter a name.']),
            ]),
            
            TextField::new('Firstname')->hideWhenUpdating()
            ->setFormTypeOption('constraints', [
                new NotBlank(['message' => 'Please enter a firstname.']),
            ]),
            
            EmailField::new('Email')
            ->setFormTypeOption('constraints', [
                new NotBlank(['message' => 'Please enter an email address.']),
            ]),
            
            CollectionField::new('Episodes')->setLabel('Episode(s) seen')->hideOnForm(),

        ];



        // si la page actuelle est celle de création d'un nouvel utilisateur
        // possibilité d'utiliser ->onlyWhenCreating()
        if (Crud::PAGE_NEW === $pageName) {

            // alors ajouter le champ de mot de passe
            $fields[] = TextField::new('password')->onlyOnForms()
                ->setLabel('Password')
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password']) // empêche le navigateur de proposer des suggestions de mots de passe
                ->setFormTypeOption('constraints', [
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])/',
                        'message' => 'The password must contain at least one lowercase letter.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])/',
                        'message' => 'The password must contain at least one uppercase letter.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*\d)/',
                        'message' => 'The password must contain at least one digit.'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[!@#$%^&*()\-_=+{};:,<.>ยง~\\\\[\]])/',
                        'message' => 'The password must contain at least one special character.'
                    ]),    
                    new Length([
                        'min' => 8,
                        'max' => 15,
                        'minMessage' => 'The password must contain at least {{ limit }} characters.'
                    ]),
                    
                ]);

        }

        return $fields;
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $user = $entityInstance; // $entityInstance : représente une instance de l'entité User

        // Si l'entité est de type User et le mot de passe n'est pas vide
        if ($user instanceof User && !empty($user->getPassword())) {

            // Hasher le mot de passe
            // $entityInstance->getPassword(): C'est la méthode qui récupère le mot de passe en clair (non haché) saisi par l'utilisateur dans le formulaire
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());

            // Définir le mot de passe hashé sur l'entité
            $user->setPassword($hashedPassword);
        }

        // Persister l'entité
        $entityManager->persist($user);
        $entityManager->flush(); // Appliquer les changements à la base de données
        
    }
}
