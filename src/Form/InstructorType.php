<?php

namespace App\Form;

use App\Entity\Instructor;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class InstructorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille - champ obligatoire',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Martins-Jacquelot',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le nom de famille est obligatoire.'),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom - champ obligatoire',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Jeff',
                ],
                'constraints' => [
                    new NotBlank(message: 'Le prénom est obligatoire.'),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email - champ obligatoire',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: j.martins@mentalworks.fr',
                ],
                'constraints' => [
                    new NotBlank(message: 'L\'email est obligatoire.'),
                    new Email(message: 'Veuillez entrer une adresse email valide.'),
                ],
            ])
            ->add('modules', EntityType::class, [
                'class' => Module::class,
                'choice_label' => function (Module $module) {
                    $blockName = $module->getTeachingBlock() ? $module->getTeachingBlock()->getName() : '';

                    return $module->getName().($blockName ? ' ('.$blockName.')' : '');
                },
                'multiple' => true,
                'expanded' => false,
                'mapped' => false,
                'label' => 'Modules enseignés - champ optionnel',
                'attr' => [
                    'class' => 'hidden',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instructor::class,
        ]);
    }
}
