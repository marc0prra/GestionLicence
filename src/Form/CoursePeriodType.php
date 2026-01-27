<?php

namespace App\Form;

use App\Entity\CoursePeriod;
use App\Entity\SchoolYear;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CoursePeriodType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // 1. L'année scolaire
            ->add('school_year_id', EntityType::class, [
                'class' => SchoolYear::class,
                'choice_label' => 'name', 
                'label' => 'Année - champ obligatoire',
                'required' => true,
                'attr' => [
                    'class' => 'w-full max-w-[400px] h-[48px] px-4 border border-gray-300 rounded-lg bg-[#F9FAFB] text-gray-600 pointer-events-none text-[15px] focus:outline-none'
                ]
            ])
            
            // 2. Date de début 
            ->add('start_date', DateType::class, [
                'label' => 'Date de début - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
                // On applique ici le style : w-full, padding à gauche pour l'icône (pl-[48px])
                'attr' => [
                    'class' => 'w-full max-w-[395px] h-[48px] pl-[48px] pr-4 border border-gray-300 rounded-lg text-[#1F384C] text-[15px] focus:outline-none focus:ring-1 focus:ring-[#1F384C]'
                ]
            ])
            
            // 3. Date de fin
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
                // Idem que date de début
                'attr' => [
                    'class' => 'w-full max-w-[395px] h-[48px] pl-[48px] pr-4 border border-gray-300 rounded-lg text-[#1F384C] text-[15px] focus:outline-none focus:ring-1 focus:ring-[#1F384C]'
                ]
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