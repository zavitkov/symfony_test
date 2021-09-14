<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $author = new Author();
            $author->setName('Автор ' . $i);
            $manager->persist($author);

            $this->addReference('Author_' . $i, $author);
        }

        $manager->flush();
    }
}
