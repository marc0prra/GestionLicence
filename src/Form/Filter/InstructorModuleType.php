<?php

namespace App\Form\Filter;

use App\Entity\Instructor_module;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InstructorModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de famille',
                'required' => false,
                'attr' => ['placeholder' => 'Saisissez un nom de famille'],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
                'attr' => ['placeholder' => 'Saisissez un prénom'],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false,
                'attr' => ['placeholder' => 'Saisissez un email'],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instructor_module::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}

