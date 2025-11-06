<?php

namespace App\DataFixtures;

use App\Repository\DepartementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class EmployeFixtures extends Fixture
{
    public function __construct(private readonly DepartementRepository $departementRepository,private readonly UserPasswordHasherInterface $passwordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $departements = $this->departementRepository->findAll();
        $counter = 1;
        foreach ($departements as $key => $departement) {
            for ($i = 1; $i <= 10; $i++) {
                $employe = new \App\Entity\Employe();
                $employe->setNomComplet("Employe " . $i );
                $employe->setTelephone("77" . str_pad($counter, 8, "0", STR_PAD_LEFT));
                $employe->setNumero("EMP" . str_pad($counter, 4, "0", STR_PAD_LEFT));
                $employe->setCreateAt(new \DateTimeImmutable());
                $employe->setEmbaucheAt(new \DateTimeImmutable());
                $employe->setUpdateAt(new \DateTimeImmutable());
                $employe->setIsDeleted(false);
                $employe->setEmail("employe".$key."".$i."@example.com");
                $HashedPassword = $this->passwordHasher->hashPassword(
                    $employe,
                    'password123'
                );
                $employe->setPassword($HashedPassword);
                $i==1 ? $employe->setRoles(['ROLE_ADMIN']) : $employe->setRoles(['ROLE_EMPLOYE']);
                $employe->setDepartement($departement);
                $manager->persist($employe);
                $counter++;
            }

        $manager->flush();
    }
}
}