<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\CoursePeriod;
use App\Entity\InterventionType;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début - champ obligatoire',
                'required' => true,
            ])
            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin - champ obligatoire',
                'required' => true,
            ])
            ->add('remotely', CheckboxType::class, [
                'label' => 'Intervention effectuée en visio',
                'required' => false,
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => false,
            ])
            ->add('course_period_id', EntityType::class, [
                'class' => CoursePeriod::class,
                'choice_label' => 'id',
            ])
            ->add('intervention_type_id', EntityType::class, [
                'class' => InterventionType::class,
                'choice_label' => 'id',
            ])
            ->add('module_id', EntityType::class, [
                'class' => Module::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
