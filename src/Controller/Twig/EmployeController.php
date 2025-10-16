<?php

namespace App\Controller\Twig;

use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DepartementRepository;

final class EmployeController extends AbstractController
{
    /*
        Lister des departements ==> GET
        Creer un departement ===> Post
    */
    public function __construct( private readonly  EmployeRepository $employeRepository,private readonly DepartementRepository $departementRepository){

    }
    #[Route('/employe/list', name: 'app_employe_list',methods: ['GET','POST'])]
    public function list(Request $request): Response
    {
        $employes= $this->employeRepository->findAll();
        $departement = $this->departementRepository->findAll();
        return $this->render('employe/list.html.twig', [
            'employes' =>$employes,
            'departement' => $departement
        ]);
    }

    #[Route('/employe/list/{idDept}', name: 'app_employe_list_by_dept')]
    public function listByID($idDept): Response
    { 
        $departement = null;
    
        $filtre = [
            "isArchived" => false
        ];
        if ($idDept != null) {
            $filtre["departement"] = $idDept;
            $departement = $this->departementRepository->find($idDept);
        }
        $employes = $this->employeRepository->findBy($filtre);
        return $this->render('employe/list.html.twig', [
            'employes' => $employes,
            "departement" => $departement,
            "titre"=> $departement->getName()?? 'Liste des employes Informatique'
        ]);
    }


    #[Route('/employe/add', name: 'app_employe_add',methods: ['GET','POST'])]
    public function save(): Response
    {
        return $this->render('employe/form.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }
}
