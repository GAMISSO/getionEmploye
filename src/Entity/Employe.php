<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
class Employe extends User
{


    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: "Le nom et le prénom de l'employe ne peut pas être vide.")]
    #[Assert\Length(
        min: 4,
        max: 25,
        minMessage: 'Le nom et le prénom doit avoir au moins {{ limit }} caractères.',
        maxMessage: 'Le nom et le prénom doit avoir au plus {{ limit }} caractères.'
    )]
    private ?string $nomComplet = null;

    #[ORM\Column(length: 15,unique: true)]
    #[Assert\NotBlank(message: "Le téléphone de l'employe est obligatoire.")]
    #[Assert\Regex(
        pattern: '/^(77|78|75|70)[0-9]{7}$/',
        message: 'Le numéro de téléphone doit commencer par 77,78,75 ou 70 et avoir 9 chiffres'
    )]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column (nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column (name: 'is_deleted',options: ['default' => false])]
    private ?bool $isDeleted = null;

    #[ORM\ManyToOne(inversedBy: 'employes')]
    #[ORM\JoinColumn(nullable: false)]

    #[Assert\NotNull(message: "Le département de l'employe est obligatoire.")]
    private ?Departement $departement = null;

    #[ORM\Column]
    private ?bool $isArchived = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThanOrEqual(
        'today',
        message: "La date d'embauche ne doit pas être supérieur à la date du jours."
        )]
    private ?\DateTimeImmutable $embaucheAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[Assert\NotNull(message: "La photo est obligatoire.")]
    #[Assert\Image(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'Veuillez télécharger une image valide (JPEG ou PNG).',
        maxSizeMessage: 'La taille maximale du fichier est de 2 Mo.',
        )]
    private $photoFile;

    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->embaucheAt = new \DateTimeImmutable();
        $this->isArchived = false;
    }



    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): static
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEmbaucheAt(): ?\DateTimeImmutable
    {
        return $this->embaucheAt;
    }

    public function setEmbaucheAt(\DateTimeImmutable $embaucheAt): static
    {
        $this->embaucheAt = $embaucheAt;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    


    /**
     * Get the value of photoFile
     */ 
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * Set the value of photoFile
     *
     * @return  self
     */ 
    public function setPhotoFile($photoFile)
    {
        $this->photoFile = $photoFile;

        return $this;
    }
}
