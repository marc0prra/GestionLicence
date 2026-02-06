<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\InterventionType;
use App\Entity\Module;
use App\Entity\Instructor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\ModuleRepository;
use App\Validator\IntervenantHasModule;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\GreaterThan;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateTimeType::class, [
                'label' => 'Date de début - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('end_date', DateTimeType::class, [
                'label' => 'Date de fin - champ obligatoire',
                'required' => true,
                'widget' => 'single_text',
            ])

            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisissez un titre sur l\'intervention'
                ]
            ])
            ->add('intervention_type_id', EntityType::class, [
                'class' => InterventionType::class,
                'choice_label' => 'name',
            ])
            ->add('module_id', EntityType::class, [
                'class' => Module::class,
                'query_builder' => function (ModuleRepository $er) {
                    return $er->queryForSelect();
                },
                'group_by' => 'parent.teachingBlock.name',
                'choice_label' => 'displayForSelect'
            ])

            ->add('courseInstructors', EntityType::class, [
                'mapped' => false,
                'class' => Instructor::class,
                'required' => true,
                'multiple' => true,
                'placeholder' => 'Choisir un intervenant...',
                'choice_label' => 'displayName',
                'attr' => [
                    'class' => 'flex-1 min-w-[150px] bg-transparent border-none outline-none text-sm cursor-pointer focus:ring-0 appearance-none',
                ],
                'constraints' => [
                    new IntervenantHasModule(),
                ],
            ])

            ->add('remotely', CheckboxType::class, [
                'label' => 'Intervention effectuée en visio',
                'required' => false,
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
