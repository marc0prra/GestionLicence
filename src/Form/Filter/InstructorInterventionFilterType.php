<?php

namespace App\Form\Filter;

use App\Entity\Module;
use App\Repository\ModuleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstructorInterventionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateTimeType::class, [
                'label' => 'Date de début',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('end_date', DateTimeType::class, [
                'label' => 'Date de fin',
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('module_id', EntityType::class, [
                'class' => Module::class,
                'query_builder' => function (ModuleRepository $er) {
                    return $er->queryForSelect();
                },
                'group_by' => 'parent.teachingBlock.name',
                'choice_label' => 'displayForSelect',
                'placeholder' => 'Sélectionnez le module',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
