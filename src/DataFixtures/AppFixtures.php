<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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

            $manager->persist($skill);
        }

        $manager->flush();
    }
}
