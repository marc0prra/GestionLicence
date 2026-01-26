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
            // 1. L'année (indispensable pour ton visuel)
            ->add('school_year_id', EntityType::class, [
                'class' => SchoolYear::class,
                'choice_label' => 'name', 
                'label' => 'Année - champ obligatoire',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            
            // 2. Date de début (une seule fois suffit !)
            ->add('start_date', DateType::class, [
                'label' => 'Date de début - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            
            // 3. Date de fin
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
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
