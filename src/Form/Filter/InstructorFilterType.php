<?php

namespace App\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstructorFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Nom de famille'],
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Prénom'],
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Email'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
