<?php

namespace App\Form;

use App\DTO\EmployeSearchFormDto;
use App\Entity\Departement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero',TextType::class,[
                'label' => 'Numéro',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche par numéro...',
                    "class" =>"form-control",
                    'autocomplete'=>'off',
                ],
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'name',
                'data' => $options['departement_default'] ?? null,
            ])
            ->add('isArchived',ChoiceType::class, [
                'label' => 'Archiver',
                'choices'  => [
                    'Actif' => true,
                    'Archiver' => false,
                ],
                'attr'=>[
                    "class" =>"form-select"
                ],
                'data' => false,
            ])
            ->add('btnSaveEmp', SubmitType::class, [
                'label' => 'Rechercher',
                "attr"=>[
                    "class"=>"btn btn-outline-secondary"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeSearchFormDto::class,
            'departement_default'=>null,
            "attr"=>[
                "data-turbo"=>'false'
            ]
            // Configure your form options here
        ]);
    }
}
