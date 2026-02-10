<?php

namespace App\Form;

use App\Entity\SchoolYear;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class SchoolYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Année',
                'attr' => ['placeholder' => '2026'],
                // L'unicité de 'name' sera gérée par l'entité (voir étape 2)
            ])
            ->add('saison', TextType::class, [
                'label' => 'Saison (format YYYY/YYYY) - champ obligatoire',
                'required' => true,
                'mapped' => false,
                'attr' => ['placeholder' => '2026/2027'],
                'constraints' => [
                    // Utilisez les arguments nommés (PHP 8)
                    new NotBlank(message: 'La saison est obligatoire'),
                    new Regex(
                        pattern: "/^\d{4}\/\d{4}$/",
                        message: 'La saison doit être au format YYYY/YYYY (ex: 2026/2027)'
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SchoolYear::class,
            'method' => 'POST',
            'csrf_protection' => false,
        ]);
    }
}
