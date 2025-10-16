<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

interface DepartementControllerInterface
{
    public function list(Request $request): Response;
}