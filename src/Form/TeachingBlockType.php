<?php

namespace App\Form;

use App\Entity\TeachingBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeachingBlockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code du bloc - champ obligatoire',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du bloc - champ obligatoire',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description - champ obligatoire',
            ])
            ->add('hours_count', IntegerType::class, [
                'label' => 'Nombre d\'heures - champ obligatoire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeachingBlock::class,
        ]);
    }
}
