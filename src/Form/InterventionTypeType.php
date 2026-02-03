<?php

namespace App\Form;

use App\Entity\InterventionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class InterventionTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 1. Le champ NOM
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Cours Magistral, TP...',
                    'class' => "w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le nom du type d\'intervention est obligatoire.'
                    )

                ],
            ])

            // 2. Le champ COULEUR (avec la validation Hexadécimale)
            ->add('color', TextType::class, [
                'label' => 'Code couleur',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: #6750A4',
                    'class' => "w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500",
                    'pattern' => '#[0-9a-fA-F]{6}',
                    'title' => 'Code hexadécimal (ex: #6750A4)',
                ],

                // Ajout d'une aide pour le format attendu
                'help' => 'Format hexadécimal (ex: #6750A4)',
                'constraints' => [
                    new NotBlank(
                        message: 'Le code couleur est obligatoire.'
                    ),
                    new Regex(
                        pattern: '/^#[0-9a-fA-F]{6}$/',
                        message: 'Le code couleur doit être au format hexadécimal valide (ex: #6750A4).'
                    ),
                ],
            ])

            // 3. Le champ DESCRIPTION
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'rows' => 4,
                    'class' => "max-w-[800px] w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500",
                    'placeholder' => 'Description du type d\'intervention...'
                ],
                
                // Validation pour s'assurer que le champ n'est pas vide
                'constraints' => [
                    new NotBlank(
                        message: 'La description est obligatoire.'
                        ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InterventionType::class,
        ]);
    }
}