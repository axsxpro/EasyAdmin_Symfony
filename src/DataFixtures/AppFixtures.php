<?php

namespace App\DataFixtures;

use App\Entity\Animation;
use App\Entity\AnimationStudio;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager): void
    {

        // initialisation d'un tableau vide
        $usersTable = [];


        //ajout d'un user
        $user = new User();
        $user->setName("User");
        $user->setFirstName("User");
        $user->setEmail("user@gmail.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Ajouter l'utilisateur créé au tableau des utilisateurs
        $usersTable[] = $user;


        //ajout d'un admin
        $admin = new User();
        $admin->setName("Admin");
        $admin->setFirstName("Admin");
        $admin->setEmail("admin@example.com");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, "admin_password")); // Définir le mot de passe admin
        $manager->persist($admin);

        $usersTable[] = $admin;



        // ajout des animations 

        $animationsTable = [];

        $animationsData = [
            ['name' => 'Demon Slayer: Kimetsu no yaiba', 'releaseDate' => '2016-02-15', 'author' => 'Koyoharu Gotōge'],
            ['name' => 'Attaque des Titans : Shingeki no Kyojin', 'releaseDate' => '2009-09-09', 'author' => 'Hajime Isayama'],
            ['name' => 'Jujutsu Kaisen', 'releaseDate' => '2018-03-05', 'author' => 'Gege Akutami'],
            ['name' => 'Chainsaw Man', 'releaseDate' => '2018-12-03', 'author' => 'Tatsuki Fujimoto']
        ];
        
        
        foreach ($animationsData as $animationData) {
            $animation = new Animation();
            $animation->setName($animationData['name']);
            $animation->setReleaseDate(new \DateTime($animationData['releaseDate']));
            $animation->setAuthor($animationData['author']);
            $manager->persist($admin);

            $animationsTable[] = $animation;
        }



        //ajout des studios d'animation

        $studioTable = [];

        $studioData = [

            'Toei Animation',
            'Ufotable',
            'Madhouse',
            'Mappa',
            'Studio Bones'

        ];


        foreach ($studioData as $data) {

            $studio =  new AnimationStudio();
            $studio->setStudioName($data);
            $manager->persist($studio);

            $studioTable[] = $studio;

        }


        //creation type de manga

        $typeTable =  [];

        $typeData = [

            'Shōnen',
            'Seinen',
            'Shōjo',
            'Josei',
            'Kodomo',
            'seijin'
    
        ];


        foreach ($typeData as $data) {

            $type =  new Type();
            $type->setType($data);
            $manager->persist($type);

            $typeTable[] = $type;

        }


        //creation des categories d'animation

        $categoryTable = [];


        $categoriesData = [

            'action', 
            'drame', 
            'surnaturel',
            'aventure',
            'romance',
            'comédie',
            'horreur'

        ];


        foreach ($categoriesData as $categorieData) {

            $category =  new Category();
            $category->setCategoryName($categorieData);
            $manager->persist($category);

            $categoryTable[] = $category;

        }


        //creation des episodes 

        $episodeTable = [];


        $episodesData = [

            ['title' => 'Cruauté', 'synopsis' => 'Kamado Tanjirô revient chez lui après avoir vendu du charbon pour découvrir sa maison attaquée. Sa sœur semble avoir survécu, mais elle agit comme un démon, ce qui remet en question les croyances de Tanjirô sur leur existence.', 'duration' => new \DateInterval('PT23M'), 'broadcasting_date' => new \DateTime('2019-04-06'), 'episode_number' => 1, 'season_number' => 1],
            
        ];

        foreach ($episodesData as $episodeData) {

            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setSynopsis($episodeData['synopsis']);
            $episode->setDuration($episodeData['duration']); 
            $episode->setBroadcastingDate($episodeData['broadcasting_date']);
            $episode->setNumberEpisode($episodeData['episode_number']);
            $episode->setNumberSeason($episodeData['season_number']);
        
            $manager->persist($episode);
        
            $episodeTable[] = $episode;
        }



        $manager->flush();
    }


}
