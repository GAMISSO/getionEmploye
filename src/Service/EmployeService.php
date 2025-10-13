<?php

namespace App\Service;
use App\Entity\Employe;
interface EmployeService{
    public function ajouterEmploye(Employe $employer):void;
    public function listerEmployes():array;
    public function listerEmployesParDepart(string $departement):array;
}