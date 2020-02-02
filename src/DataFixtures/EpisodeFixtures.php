<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            $episode->setnumber($faker->numberBetween(1, 20));
            $episode->setTitle($faker->realText($maxNbChars = 20, $indexSize = 1));
            $episode->setSynopsis($faker->realText($maxNbChars = 150, $indexSize = 2));
            $episode->setSeason($this->getReference('season_'. rand(0, 5)));
            $manager->persist($episode);

        }
        $manager->flush();

    }
}