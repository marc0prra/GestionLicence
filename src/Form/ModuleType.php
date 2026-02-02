<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\TeachingBlock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $blocActuel = $options['bloc_actuel'];

        $builder
            ->add('teachingBlock', EntityType::class, [ 
                'class' => TeachingBlock::class,
                'choice_label' => function (TeachingBlock $bloc) {
                    return $bloc->getCode() . ' - ' . $bloc->getDescription();
                },
                'label' => 'Bloc enseignement',
                'disabled' => true,
                'required' => false,
            ])
            ->add('code', TextType::class, [
                'label' => 'Code',
                'required' => true,
                'help' => 'Champ obligatoire, doit être unique.',
                'attr' => [
                    'class' => "w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le code du bloc est obligatoire'
                    )
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => "w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'Le nom du module est obligatoire'
                    )
                ]
            ])
            ->add('hoursCount', IntegerType::class, [
                'label' => 'Nombre d\'heures',
                'required' => false,
            ])
            ->add('parent', EntityType::class, [
                'class' => Module::class,
                'label' => 'Parent',
                'required' => false,
                'placeholder' => 'Sélectionnez un parent (optionnel)',
                'choice_label' => 'name',
                'choices' => $blocActuel ? $blocActuel->getModules() : [],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows' => 4],
                'attr' => [
                    'class' => "w-full max-w-[395px] bg-[#F9FAFB] px-4 py-2 border border-gray-300 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                ],
                'constraints' => [
                    new NotBlank(
                        message: 'La description du module est obligatoire'
                    )
                ]
            ])
            ->add('capstoneProject', CheckboxType::class, [
                'label' => 'Module effectué sur le projet fil rouge',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
            'bloc_actuel' => null,
        ]);
        $resolver->setAllowedTypes('bloc_actuel', ['null', TeachingBlock::class]);
    }
}
