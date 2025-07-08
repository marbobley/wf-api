<?php

namespace App\DataFixtures;

use App\Entity\CategorySkill;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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
            $skill->setCategory('cat_' . $i);
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
