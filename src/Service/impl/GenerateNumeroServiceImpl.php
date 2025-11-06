<?php
namespace App\Service\impl;
use App\Service\GenerateNumeroService;
class GenerateNumeroServiceImpl implements GenerateNumeroService
{
    public function generateNumero(): string
    {
        $numero="EMP".strtoupper(bin2hex(random_bytes(4)));
        return $numero;
    }
}