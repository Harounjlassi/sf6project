<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixuture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hobbies = [
            "Painting",
            "Gardening",
            "Playing Guitar",
            "Hiking",
            "Photography",
            "Cooking",
            "Dancing",
            "Reading",
            "Singing",
            "Yoga",
        ];
        for($i=0;$i<count($hobbies);$i++) {
            $hobby = new Hobby();
            $hobby->setDesignation($hobbies[$i]);
            $manager->persist($hobby);



        }



        $manager->flush();
    }
}
