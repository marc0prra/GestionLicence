<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SchoolYearType extends AbstractType
{
    public function buildform(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', TextType::class, [
                'label' => 'Année - champ obligatoire',
                'required' => true,
            ])
            ->add('season', TextType::class, [
                'label' => 'Saison (format YYYY/YYYY) - champ obligatoire',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'method' => 'POST',
            'csrf_protection' => false
        ]);
    }
}