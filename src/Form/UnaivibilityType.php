<?php

namespace App\Form;

use App\Entity\Instructor;
use App\Entity\Unaivibility;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UnaivibilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'label' => 'Date de début',
                'constraints' => [
                    new NotBlank(
                        message: 'La date de début est obligatoire',
                    )
                ]
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'Date de fin',
                'constraints' => [
                    new NotBlank(
                        message: 'La date de fin est obligatoire',
                    ),
    
                ]
            ])
            ->add('reason', TextareaType::class, [
                'label' => 'Motif',
                'required' => false,
                'constraints' => [
                    new Length(
                        max: 255,
                        maxMessage: 'Le motif ne peut contenir que {{ limit }} caractères.',
                    )
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Unaivibility::class,
        ]);
    }
}
