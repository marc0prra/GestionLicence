<?php

namespace App\Form;

use App\Entity\CoursePeriod;
use App\Entity\SchoolYear;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursePeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('school_year_id', EntityType::class, [
                'class' => SchoolYear::class,
                'choice_label' => 'name',
                'label' => 'Année - champ obligatoire',
                'disabled' => true, 
                'attr' => [
                    'class' => 'w-full bg-gray-100 text-gray-500 border border-gray-300 rounded px-3 py-2 cursor-not-allowed'
                ]
            ])
            ->add('start_date', DateType::class, [
                'label' => 'Date de début - champ obligatoire',
                'widget' => 'single_text',
                'html5' => true, 
                'attr' => ['class' => 'w-full border border-gray-300 rounded px-3 py-2']
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin - champ obligatoire',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'w-full border border-gray-300 rounded px-3 py-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CoursePeriod::class,
        ]);
    }
}