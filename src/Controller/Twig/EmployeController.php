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
    private const LIMIT=15;
    /*
        Lister des departements ==> GET
        Creer un departement ===> Post
    */
    public function __construct( private readonly  EmployeRepository $employeRepository,private readonly DepartementRepository $departementRepository){

    }
    #[Route('/employe/list', name: 'app_employe_list',methods: ['GET','POST'])]
    public function list(Request $request): Response
    {
        
        $departement = $this->departementRepository->findAll();
        $page=$request->query->get("page",1);
        $offset=($page-1)*self::LIMIT;
        $count=$this->employeRepository->count([]);
        $nbrePage=ceil($count/self::LIMIT);

        $employes = $this->employeRepository->findBy([],null,self::LIMIT,$offset);
        return $this->render('employe/list.html.twig', [
            'employes' =>$employes,
            'departements' => $departement,
            "nbrePage"=>$nbrePage,
            "pageEncours"=>$page,
            "titre"=>  'Liste des employes'
        ]);
    }

    #[Route('/employe/list/{idDept}', name: 'app_employe_list_by_dept')]
    public function listByID($idDept,Request $request): Response
    { 
        $departement = null;
    
        $filtre = [
            "isArchived" => false
        ];
        $departements = $this->departementRepository->findAll();
        if ($idDept != null) {
            $filtre["departement"] = $idDept;
            $departement = $this->departementRepository->find($idDept);
        }

        $page=$request->query->get("page",1);
        $offset=($page-1)*self::LIMIT;
        $count=$this->employeRepository->count($filtre);
        $nbrePage=ceil($count/self::LIMIT);

        $employes = $this->employeRepository->findBy($filtre,null,self::LIMIT,$offset);
        return $this->render('employe/list.html.twig', [
            'employes' => $employes,
            "nbrePage"=>$nbrePage,
            "pageEncours"=>$page,
            "departement" => $departement,
            "departements"=>$departements,
            "titre"=> $departement->getName()?? 'Liste des employes'
        ]);
    }


    #[Route('/employe/add', name: 'app_employe_add',methods: ['GET','POST'])]
    public function save(): Response
    {
        $departements = $this->departementRepository->findAll();
        return $this->render('employe/form.html.twig', [
            'controller_name' => 'EmployeController',
            "departements"=>$departements,
        ]);
    }
}
