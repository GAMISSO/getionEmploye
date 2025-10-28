<?php

namespace App\Controller\Twig;

use App\Controller\DepartementControllerInterface;
use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DepartementController extends AbstractController implements DepartementControllerInterface
{
    private const LIMIT=4;

    public function __construct( private readonly  DepartementRepository $departementRepository){

    }
    #[Route('/departement/list', name: 'app_departement_list', methods: ['GET','POST'])]
    public function list(Request $request): Response
    {
        $page=$request->query->get("page",1);
        $offset=($page-1)*self::LIMIT;
        $departements= $this->departementRepository->findBy([],null,self::LIMIT,$offset);
        $count=$this->departementRepository->count([]);
        $nbrePage=ceil($count/self::LIMIT);
        return $this->render('departement/list.html.twig', [
            'datas' => $departements,
            "nbrePage"=>$nbrePage,
            "pageEncours"=>$page
        ]);
    }
}
