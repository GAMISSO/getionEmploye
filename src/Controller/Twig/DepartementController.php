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

    public function __construct( private readonly  DepartementRepository $departementRepository){

    }
    #[Route('/departement/list', name: 'app_departement_list', methods: ['GET','POST'])]
    public function list(Request $request): Response
    {
        $departements= $this->departementRepository->findAll();
        return $this->render('departement/list.html.twig', [
            'datas' => $departements
        ]);
    }
}
