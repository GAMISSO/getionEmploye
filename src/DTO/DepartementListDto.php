<?php
namespace App\DTO;

use App\Entity\Departement;
use \DateTimeImmutable;

class DepartementListDto
{
    public int $id;
    public string $name;
    public ?bool $isDeleted=null;
    public int $nbreEmploye=0;
    public DateTimeImmutable $createAt;


    public static function formEntitie(Departement $entity): DepartementListDto
    {
        $dto = new DepartementListDto();
        $dto->id = $entity->getId();
        $dto->name = $entity->getName();
        $dto->isDeleted = $entity->isDeleted();
        $dto->nbreEmploye = $entity->getNbreEmploye();
        $dto->createAt = $entity->getCreateAt();

        return $dto;
    }

    public static function formEntities(array $entities): array
    {
        return array_map (function(Departement $entity) {
            return self::formEntitie($entity);
        }, $entities);
    }
}