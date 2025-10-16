<?php

namespace App\DataFixtures;

use App\Repository\DepartementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function __construct(private readonly DepartementRepository $departementRepository)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $departements = $this->departementRepository->findAll();
        $counter = 1;
        foreach ($departements as $departement) {
            for ($i = 1; $i <= 10; $i++) {
                $employe = new \App\Entity\Employe();
                $employe->setNomComplet("Employe " . $i );
                $employe->setTelephone("06" . str_pad($counter, 8, "0", STR_PAD_LEFT));
                $employe->setCreateAt(new \DateTimeImmutable());
                $employe->setUpdateAt(new \DateTimeImmutable());
                $employe->setIsDeleted(false);
                $employe->setDepartement($departement);
                $manager->persist($employe);
                $counter++;
            }

        $manager->flush();
    }
}
}