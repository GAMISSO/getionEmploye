<?php

namespace App\Controller\Twig;

use App\Controller\DepartementControllerInterface;
use App\DTO\DepartementListDto;
use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DepartementController extends AbstractController implements DepartementControllerInterface
{

    public function __construct( private readonly  DepartementRepository $departementRepository){

    }
    #[Route('/departement/list', name: 'app_departement_list', methods: ['GET','POST'])]
    public function list(Request $request): Response
    {
        $departement=new Departement();
        $form=$this->createForm(DepartementType::class,$departement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // $this->manager->persist($departement);
            // $this->manager->flush();
            $departement->setIsDeleted(false);
            $this->departementRepository->save($departement,true);
            return $this->redirectToRoute('app_departement_list');
        }
        $page=$request->query->get("page",1);
        $offset=($page-1)*$this->getParameter('LIMIT_PER_PAGE');
        $departements= $this->departementRepository->findBy([],[
            'id'=>"desc"
        ],$this->getParameter('LIMIT_PER_PAGE'),$offset);

        $departementsDto=DepartementListDto::formEntities($departements);

        $this->addFlash('success','Département ajouté avec succès');
        $count=$this->departementRepository->count([]);
        $nbrePage=ceil($count/$this->getParameter('LIMIT_PER_PAGE'));
        return $this->render('departement/list.html.twig', [
            'datas' => $departementsDto,
            "nbrePage"=>$nbrePage,
            "pageEncours"=>$page,
            "formDept"=>$form->createView()
        ]);
    }
}
