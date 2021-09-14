<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $book = new Book();
            $book->setAuthor($this->getReference('Author_' . rand(1, 100)));
            $book->translate('ru')->setName('Книга '  . $i);
            $book->translate('en')->setName('Book' . $i);

            $manager->persist($book);

            $book->mergeNewTranslations();
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [AuthorFixtures::class];
    }
}
