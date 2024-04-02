<?php

namespace App\Form;

use App\Entity\Truck;
use App\Repository\TruckRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class TruckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('disponibilite', ChoiceType::class,[
                'choices' => [
                    'available'=>'available',
                    'unavailable'=>'Unavailable',
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Truck::class,
        ]);
    }
}