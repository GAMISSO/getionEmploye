<?php

namespace App\Service;
use App\Entity\Departement;
interface DepartementService{
    public function getAllDepartements():array;
    public function getDepartementById(int $id):?Departement;
}