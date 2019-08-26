<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tutorial;

class TutorialFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tutorial = new Tutorial();
        $tutorial->setTitle('Tutoriel N°1')
        ->setContent('Dans cette vidéo on va apprendre à se connecter à wordpress.')
        ->setPublishAt(new \Datetime('now'))
        ->setIsPublish(True)
        ->setVideoLink('https://www.youtube.com/watch?v=D-qNageiKXg&list=RDD-qNageiKXg&start_radio=1');

         $manager->persist($tutorial);

        $manager->flush();
    }
}
