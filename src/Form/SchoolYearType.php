<?php

namespace App\Form;

use App\Entity\SchoolYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SchoolYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Année - champ obligatoire',
                'required' => true,
                'attr' => ['placeholder' => '2026'],
            ])
            ->add('saison', TextType::class, [
                'label' => 'Saison (format YYYY/YYYY) - champ obligatoire',
                'required' => true,
                'mapped' => false,
                'attr' => ['placeholder' => '2026/2027'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SchoolYear::class,
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }
}