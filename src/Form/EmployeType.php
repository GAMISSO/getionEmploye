<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Employe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero',TextType::class,[
                'label' => 'Numéro',
                'attr' => [
                    'readonly' => true,
                    'placeholder' => 'Numéro'
                ],
            ])
            ->add('nomComplet',TextType::class,[
                'label' => 'Nom complet',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom complet'
                ],
            ])
            ->add('telephone',null,[
                'required' => false,
            ])
            ->add('embaucheAt',DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'embauche',
                'required' => false,
            ])

            ->add('departement', EntityType::class, [
                'required' => false,
                'class' => Departement::class,
                'choice_label' => 'name',
            ])
            ->add('isArchived',ChoiceType::class, [
                'label' => 'Archiver',
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'data' => false,
            ])
            ->add('addresse',TextType::class,[
                'label' => 'Adresse',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
            ])
            ->add('photoFile',FileType::class,[
                'label' => 'photo',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mettez votre photo',
                    'accept'=>"image/jpeg,image/png"
                ],
            ])
            ->add('btnSaveEmp', SubmitType::class, [
                'label' => 'Enregistrer',
                "attr"=>[
                    "class"=>"btn btn-primary final-end"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
            "attr"=>[
                "data-turbo"=>'false'
            ]
        ]);
    }
}
