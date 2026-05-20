<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use App\Entity\Abonne;
use App\Entity\Emprunt;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Créer des utilisateurs
        $user1 = new User();
        $user1->setEmail('admin@biblio.com');
        $user1->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'password123');
        $user1->setPassword($hashedPassword);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('bibliothecaire@biblio.com');
        $user2->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword($user2, 'password123');
        $user2->setPassword($hashedPassword);
        $manager->persist($user2);

        // Créer des livres
        $livres = [
            ['titre' => 'Le Seigneur des Anneaux', 'auteur' => 'J.R.R. Tolkien', 'isbn' => '978-2-253-04940-5', 'date' => '1954-07-29'],
            ['titre' => 'Harry Potter à l\'école des sorciers', 'auteur' => 'J.K. Rowling', 'isbn' => '978-2-07-061275-8', 'date' => '1997-06-26'],
            ['titre' => '1984', 'auteur' => 'George Orwell', 'isbn' => '978-2-07-036822-8', 'date' => '1949-06-08'],
            ['titre' => 'Le Hobbit', 'auteur' => 'J.R.R. Tolkien', 'isbn' => '978-2-253-04941-2', 'date' => '1937-09-21'],
            ['titre' => 'Les Misérables', 'auteur' => 'Victor Hugo', 'isbn' => '978-2-07-014211-7', 'date' => '1862-04-16'],
            ['titre' => 'Le Comte de Monte-Cristo', 'auteur' => 'Alexandre Dumas', 'isbn' => '978-2-07-036822-9', 'date' => '1844-08-28'],
            ['titre' => 'Le Petit Prince', 'auteur' => 'Antoine de Saint-Exupéry', 'isbn' => '978-2-07-061275-8', 'date' => '1943-04-06'],
            ['titre' => 'Don Quichotte', 'auteur' => 'Miguel de Cervantes', 'isbn' => '978-2-07-036824-2', 'date' => '1605-01-16'],
            ['titre' => 'Orgueil et Préjugés', 'auteur' => 'Jane Austen', 'isbn' => '978-0-14-143951-8', 'date' => '1813-01-28'],
            ['titre' => 'Fondation', 'auteur' => 'Isaac Asimov', 'isbn' => '978-2-07-041573-1', 'date' => '1951-06-01'],

        ];

        $livreObjects = [];
        foreach ($livres as $livreData) {
            $livre = new Livre();
            $livre->setTitre($livreData['titre']);
            $livre->setAuteur($livreData['auteur']);
            $livre->setIsbn($livreData['isbn']);
            $livre->setDatePublication(new \DateTime($livreData['date']));
            $livre->setDisponible(true);
            $manager->persist($livre);
            $livreObjects[] = $livre;
        }

        // Créer des abonnés
        $abonnes = [
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'jean.dupont@email.com'],
            ['nom' => 'Martin', 'prenom' => 'Marie', 'email' => 'marie.martin@email.com'],
            ['nom' => 'Bernard', 'prenom' => 'Pierre', 'email' => 'pierre.bernard@email.com'],
            ['nom' => 'Dubois', 'prenom' => 'Sophie', 'email' => 'sophie.dubois@email.com'],
            ['nom' => 'Lefebvre', 'prenom' => 'Luc', 'email' => 'luc.lefebvre@email.com'],
        ];

        $abonneObjects = [];
        foreach ($abonnes as $abonneData) {
            $abonne = new Abonne();
            $abonne->setNom($abonneData['nom']);
            $abonne->setPrenom($abonneData['prenom']);
            $abonne->setEmail($abonneData['email']);
            $abonne->setDateInscription(new \DateTime('-6 months'));
            $manager->persist($abonne);
            $abonneObjects[] = $abonne;
        }

        // Créer des emprunts
        for ($i = 0; $i < 7; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setLivre($livreObjects[$i % count($livreObjects)]);
            $emprunt->setAbonne($abonneObjects[$i % count($abonneObjects)]);
            $emprunt->setDateEmprunt(new \DateTime('-' . (10 - $i) . ' days'));
            $emprunt->setDateRetourPrevue(new \DateTime('+' . (14 - $i) . ' days'));

            // Quelques livres sont retournés
            if ($i < 3) {
                $emprunt->setDateRetourEffective(new \DateTime('-' . (5 - $i) . ' days'));
            }

            $manager->persist($emprunt);
        }

        $manager->flush();
    }
}
