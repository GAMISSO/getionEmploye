<?php

namespace App\Controller\Twig;

use App\DTO\DepartementListDto;
use App\DTO\EmployeListDto;
use App\DTO\EmployeSearchFormDto;
use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use App\Service\FileUploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DepartementRepository;
use App\Service\GenerateNumeroService;

final class EmployeController extends AbstractController
{
    /*
        Lister des departements ==> GET
        Creer un departement ===> Post
    */
    public function __construct( private readonly  EmployeRepository $employeRepository,private readonly DepartementRepository $departementRepository){

    }
    #[Route('/employe/list/{idDept?}', name: 'app_employe_list', methods: ['GET', 'POST'])]
public function list(Request $request, int $idDept = null): Response
{
    $searchFormDto = new EmployeSearchFormDto();
    $departement = null;
    $form = $this->createForm(\App\Form\EmployeSearchType::class, $searchFormDto,[
        'method'=>'GET',
        //'action'=>$this->generateUrl('app_employe_list',['idDept'=>$idDept]),
        'departement_default'=>$departement,
        'csrf_protection'=>false,
    ]);

    $filtre = ["isArchived" => false];

    // Récupération des données du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        if (!empty($searchFormDto->numero)) {
            $filtre['numero'] = $searchFormDto->numero;
        }

        if (!empty($searchFormDto->departement)) {
            $filtre['departement'] = $searchFormDto->departement;
        }

        $filtre['isArchived'] = $searchFormDto->isArchived;
    }

    // Si un département est passé dans l’URL
    if ($idDept !== null) {
        $filtre['departement'] = $idDept;
        $departement = $this->departementRepository->find($idDept);
    }

    // Récupération des départements
    $departements = $this->departementRepository->findAll();

    // Pagination
    $page = $request->query->getInt('page', 1);
    $offset = ($page - 1) * $this->getParameter('LIMIT_PER_PAGE');
    $count = $this->employeRepository->count($filtre);
    $nbrePage = ceil($count / $this->getParameter('LIMIT_PER_PAGE'));

    // Récupération des employés selon le filtre
    $employes = $this->employeRepository->findBy($filtre, [
        'id' => 'desc'
    ], $this->getParameter('LIMIT_PER_PAGE'), $offset);

    // Conversion en DTOs
    $employeDto = EmployeListDto::formEntities($employes);
    $departementDto = DepartementListDto::formEntities($departements);

    // Rendu Twig
    return $this->render('employe/list.html.twig', [
        'employes' => $employeDto,
        'departements' => $departementDto,
        'departement' => $departement,
        'nbrePage' => $nbrePage,
        'pageEncours' => $page,
        'formSearch' => $form->createView(),
        'titre' => $departement ? $departement->getName() : 'Liste des employés'
    ]);
}


    


    #[Route('/employe/add', name: 'app_employe_add',methods: ['GET','POST'])]
    public function save(Request $request,GenerateNumeroService $numService,FileUploaderService $fileUploader): Response
    {
        $employe = new Employe();
        $employe->setNumero( $numService->generateNumero());
        $form=$this->createform(EmployeType::class,$employe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $addresse = $form->get('addresse')->getData();
            $employe->setIsDeleted(false);

            $photoFile = $employe->getPhotoFile();
            if ($photoFile) {
                $photoName=$fileUploader->upload($photoFile);

                $employe->setPhoto($photoName);
            }

            $this->employeRepository->save($employe,true);
            $this->addFlash('success','Employe ajouté avec succès');
            return $this->redirectToRoute('app_employe_list');
        }
        $departements = $this->departementRepository->findAll();
        return $this->render('employe/form.html.twig', [
            'formEmp' => $form->createView(),
            "departements"=>$departements,
        ]);
    }
}
