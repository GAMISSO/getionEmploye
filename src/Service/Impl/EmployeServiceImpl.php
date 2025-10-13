<?php

namespace App\Service\Impl;
use App\Service\EmployeService;
use App\Entity\Employe;
use App\Repository\EmployeRepository;
use App\Repository\DepartementRepository;

class EmployeServiceImpl implements EmployeService{
    private EmployeRepository $employeRepository;
    private DepartementRepository $departementRepository;

    public function __construct(EmployeRepository $employeRepository, DepartementRepository $departementRepository){
        $this->employeRepository=$employeRepository;
        $this->departementRepository=$departementRepository;
    }
    private array $employes=[];
    public function ajouterEmploye(Employe $employer):void{
        $this->employes[]=$employer;
    }

    public function listerEmployes():array{
        return $this->employes;
    }

    public function listerEmployesParDepart(string $departement):array{
        return array_filter($this->employes,function(Employe $employe) use ($departement){
            return $employe->getDepartement()->getName()===$departement;
        });
    }
}