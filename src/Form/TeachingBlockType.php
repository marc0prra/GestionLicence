<?php

namespace App\Form;

use App\Entity\TeachingBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class TeachingBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code du bloc - champ obligatoire',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'class' => 'w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500',
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le code du bloc est obligatoire'
                    ),
                ],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du bloc - champ obligatoire',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    'class' => 'w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500',
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le nom du bloc est obligatoire'
                    ),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description - champ obligatoire',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisissez une description',
                    'class' => 'max-w-[800px] w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500',
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'La description est obligatoire'
                    ),
                ],
            ])
            ->add('hours_count', IntegerType::class, [
                'label' => 'Nombre d\'heures - champ obligatoire',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Saisissez le nombre d\'heures',
                    'class' => 'max-w-[395px] w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500',
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le nombre d\'heures est obligatoire'
                    ),
                    new Positive(
                        message: 'Le nombre d\'heures doit être positif'
                    ),
                    new Type(
                        type: 'int',
                        message: 'Le nombre d\'heures doit être un entier'
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeachingBlock::class,
        ]);
    }
}
