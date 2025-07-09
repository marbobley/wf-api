<?php

namespace App\DataFixtures;

use App\Entity\CategorySkill;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class AppFixtures extends Fixture
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        //Creation user 
        $user = new User();
        $user->setEmail('user@skill.com');
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@skill.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        $cat1 = new CategorySkill();
        $cat1->setName('Architecture');
        $cat1->setDescription('MVC , MVVM ....');
        $cat2 = new CategorySkill();
        $cat2->setName('Outil');
        $cat2->setDescription('');
        $cat3 = new CategorySkill();
        $cat3->setName('Langage');
        $cat3->setDescription('');
        $cat4 = new CategorySkill();
        $cat4->setName('Framework');
        $cat4->setDescription('');
        $cat5 = new CategorySkill();
        $cat5->setName('Projet');
        $cat5->setDescription('');
        $cat6 = new CategorySkill();
        $cat6->setName('Architecture');
        $cat6->setDescription('');
        $cat7 = new CategorySkill();
        $cat7->setName('Logiciel');
        $cat7->setDescription('');
        $cat8 = new CategorySkill();
        $cat8->setName('Environnement');
        $cat8->setDescription('');
        $cat9 = new CategorySkill();
        $cat9->setName('Documentation');
        $cat9->setDescription('');
        $cat10 = new CategorySkill();
        $cat10->setName('Metier');
        $cat10->setDescription('');
        $cat11 = new CategorySkill();
        $cat11->setName('Parler');
        $cat11->setDescription('');


        
            $manager->persist($cat1);
            $manager->persist($cat2);
            $manager->persist($cat3);
            $manager->persist($cat4);
            $manager->persist($cat5);
            $manager->persist($cat6);
            $manager->persist($cat7);
            $manager->persist($cat8);
            $manager->persist($cat9);
            $manager->persist($cat10);
            $manager->persist($cat11);

        // $product = new Product();
        // $manager->persist($product);
        for($i = 0 ; $i < 20 ; $i++ ){
            $skill = new Skill;
            $skill->setDescription('des_' . $i);
            $skill->setEvaluation('eva_' . $i);
            $skill->setImgSource('imgSrc_' . $i);
            $skill->setLanguage('lang_' . $i);
            $skill->setLevel($i);
            $skill->setYearOfExperience('cat_' . $i);
            $skill->addCategorySkill( $i % 2 ? $cat1 : $cat2);

            $manager->persist($skill);
        }

        $manager->flush();
    }
}
