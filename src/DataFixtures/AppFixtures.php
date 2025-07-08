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
        $cat2->setName('Langage');
        $cat2->setDescription('');
        
            $manager->persist($cat1);
            $manager->persist($cat2);

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
