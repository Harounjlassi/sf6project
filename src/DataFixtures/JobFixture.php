<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobs = [
            "Web Developer",
            "Graphic Designer",
            "Data Analyst",
            "Software Engineer",
            "UI/UX Designer",
            "Marketing Manager",
            "Project Manager",
            "Sales Representative",
            "Content Writer",
            "Accountant",
        ];
        for($i=0;$i<count($jobs);$i++) {
            $job = new Job();
            $job->setDesignation($jobs[$i]);
            $manager->persist($job);



        }



        $manager->flush();
    }
}
