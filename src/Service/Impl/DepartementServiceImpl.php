<?php

namespace App\Service\Impl;

use App\Service\DepartementService;
use App\Repository\DepartementRepository;
use App\Entity\Departement;

class DepartementServiceImpl implements DepartementService{
    private DepartementRepository $departementRepository;

    public function __construct(DepartementRepository $departementRepository){
        $this->departementRepository=$departementRepository;
    }

    public function getAllDepartements():array{
        return $this->departementRepository->findAll();
    }

    public function getDepartementById(int $id):?Departement{
        return $this->departementRepository->find($id);
    }

}
