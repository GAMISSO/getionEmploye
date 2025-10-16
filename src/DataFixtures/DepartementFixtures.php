<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class DepartementFixtures extends Fixture
{

    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $departements = ['Informatique', 'Ressources Humaines', 'Marketing', 'Ventes', 'Finance'];
        foreach ($departements as $name) {
            $departement = new Departement();
            $departement->setName($name);
            $departement->setCreateAt(new \DateTimeImmutable());
            $departement->setIsDeleted(false);
            $manager->persist($departement);
            // $manager->remove($departement);
        }

        $manager->flush();
    }
}
