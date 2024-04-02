<?php

namespace App\Form;

use App\Entity\Mission;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('id_waste',null, [
            'attr' => [
                'placeholder' => 'Waste',
            ]])

            ->add('start_date',DateTimeType::class, [
                'widget' => 'single_text',
                
            ]
            )
            ->add('end_date',DateTimeType::class, [
                'widget' => 'single_text',
                
            ])
            
            
           
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
