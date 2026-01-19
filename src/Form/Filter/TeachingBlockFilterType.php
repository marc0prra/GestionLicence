<?php

namespace App\Form\Filter;

use App\Entity\TeachingBlock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TeachingBlockFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code',
                'required' => false,
                'attr' => ['placeholder' => 'Saisissez un code'],
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom du bloc',
                'required' => false,
                'attr' => ['placeholder' => 'Saisissez un nom'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeachingBlock::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
