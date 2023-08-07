<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LibraryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //utiliser faker
        $faker = Factory::create('fr_FR');

        //creer les Books 
        for ($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setTitle($faker->word());
            $book->setAuthor($faker->word());
            $book->setDescription($faker->paragraphs(2, true));
            $book->setNbBooks($faker->numberBetween(1, 10));
            $book->setNbBorrowedBooks($faker->numberBetween(0, $book->getNbBooks()));
            
            //sauvegarder les Books
            $manager->persist($book);
        }
            //valider la création des livres dans le bdd
             $manager->flush();   
    }
}

