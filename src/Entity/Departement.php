<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
#[ORM\Table(name: 'departements')]
#[UniqueEntity(fields: ['name'], message: 'la {{ valeur }} existe déjà.')]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le nom du département ne peut pas être vide.")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom du département doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le nom du département ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[ORM\Column(length: 100,unique: true)]
    private ?string $name = null;

    #[ORM\Column(name: 'create_at')]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column(name: 'update_at', nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(name: 'is_deleted',options: ['default' => false])]
    private ?bool $isDeleted = null;

    /**
     * @var Collection<int, Employe>
     */
    #[ORM\OneToMany(targetEntity: Employe::class, mappedBy: 'departement')]
    private Collection $employes;

    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->employes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection<int, Employe>
     */
    public function getEmployes(): Collection
    {
        return $this->employes;
    }

    public function addEmploye(Employe $employe): static
    {
        if (!$this->employes->contains($employe)) {
            $this->employes->add($employe);
            $employe->setDepartement($this);
        }

        return $this;
    }

    public function removeEmploye(Employe $employe): static
    {
        if ($this->employes->removeElement($employe)) {
            // set the owning side to null (unless already changed)
            if ($employe->getDepartement() === $this) {
                $employe->setDepartement(null);
            }
        }

        return $this;
    }

    public function getNbreEmploye(): int
    {
        return count($this->employes);
    }

}
