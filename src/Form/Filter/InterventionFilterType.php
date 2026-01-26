<?php
namespace App\Form\Filter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Repository\ModuleRepository;
use App\Entity\Module;

class CourseFilterType extends AbstractController
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', DateTimeType::class, [
                'label' => 'Date de début - champ obligatoire',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('end_date', DateTimeType::class, [
                'label' => 'Date de fin - champ obligatoire',
                'required' => true,
                'widget' => 'single_text'
            ])
            ->add('module_id', EntityType::class, [
                'class' => Module::class,
                'query_builder' => function (ModuleRepository $er) {
                    return $er->queryForSelect();
                },
                'group_by' => 'parent.teachingBlock.name',
                'choice_label' => 'displayForSelect'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }
}
