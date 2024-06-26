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
use Faker\Factory;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        // initialisation d'un tableau vide
        $usersTable = [];

        for ($i = 1; $i <= 5; $i++) {

            //ajout d'un user
            $user = new User();
            $user->setName("User" . $i);
            $user->setFirstName("User" . $i);
            $user->setEmail("user" . $i . "@gmail.com");
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
            $manager->persist($user);

            // Ajouter l'utilisateur créé au tableau des utilisateurs
            $usersTable[] = $user;
        }

        //ajout d'un admin
        $admin = new User();
        $admin->setName("Admin");
        $admin->setFirstName("Admin");
        $admin->setEmail("admin@example.com");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, "admin_password")); // Définir le mot de passe admin
        $manager->persist($admin);

        $usersTable[] = $admin;


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
            'Seijin'

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
            $animation->setAnimationStudio($faker->randomElement($studioTable));
            $animation->setType($faker->randomElement($typeTable));
            $animation->addCategory($faker->randomElement($categoryTable));

            $manager->persist($animation);

            $animationsTable[] = $animation;
        }


        //creation des episodes 
        $episodeTable = [];

        $episodesData = [

            ['title' => 'Cruauté', 'synopsis' => 'Kamado Tanjirô revient chez lui après avoir vendu du charbon pour découvrir sa maison attaquée. Sa sœur semble avoir survécu, mais elle agit comme un démon, ce qui remet en question les croyances de Tanjirô sur leur existence.', 'duration' => 23, 'broadcasting_date' => new \DateTime('2019-04-06'), 'episode_number' => 1, 'season_number' => 1],
            ['title' => 'À toi qui vis 2000 ans plus tard : La chute de Shiganshina - Partie 1', 'synopsis' => 'Après un siècle de paix, l\'humanité est brusquement confrontée au retour de la terreur des Titans.', 'duration' => 23, 'broadcasting_date' => new \DateTime('2013-04-14'), 'episode_number' => 1, 'season_number' => 1],
            ['title' => 'Ryomen Sukuna', 'synopsis' => 'Yuji Itadori, élève de seconde, est attiré par le club de spiritisme de son lycée, mais reste sceptique quant au surnaturel. Un étranger prétend récupérer un objet volé par Yuji dans une station météo, affirmant qu\'il s\'agit d\'une relique protectrice contre les monstres.', 'duration' => 23, 'broadcasting_date' => new \DateTime('2020-10-02'), 'episode_number' => 1, 'season_number' => 1],
            ['title' => 'Le chien et la tronçonneuse', 'synopsis' => 'Denji mène une vie calme avec Pochita, son chien-démon-tronçonneuse, malgré ses dettes. Engagé par la pègre comme chasseur de démons, il se retrouve piégé, risquant ainsi sa vie.', 'duration' => 23, 'broadcasting_date' => new \DateTime('2022-10-11'), 'episode_number' => 1, 'season_number' => 1],

        ];

        foreach ($episodesData as $index => $episodeData) {

            $episode = new Episode();
            $episode->setTitle($episodeData['title']);
            $episode->setSynopsis($episodeData['synopsis']);
            $duration = new \DateTime(); // Créer un objet DateTime pour la durée de l'épisode
            $duration->setTime(0, $episodeData['duration'], 0); // Heures, minutes, secondes (0 heures, durée de l'épisode, 0 secondes)
            $episode->setDuration($duration);
            $episode->setBroadcastingDate($episodeData['broadcasting_date']);
            $episode->setNumberEpisode($episodeData['episode_number']);
            $episode->setNumberSeason($episodeData['season_number']);

            // Assurer qu'il existe une animation correspondante pour chaque épisode
            // ajout d'une animation pour chaque épisode 
            if (isset($animationsTable[$index])) {

                $animation = $animationsTable[$index];
                $episode->setAnimation($animation);
            }

            $manager->persist($episode);

            $episodeTable[] = $episode;
        }


        // associer un episode à chaque utilisateur
        foreach ($usersTable as $user) {

            // on ajoute à chaque utilisateur un episode au hasard
            $user->addEpisode($faker->randomElement($episodeTable));
            $manager->persist($user);
        }


        $manager->flush();
    }
}
