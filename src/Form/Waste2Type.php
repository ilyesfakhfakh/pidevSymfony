<?php

namespace App\Form;

use App\Entity\Waste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Truck;
class Waste2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type', ChoiceType::class,[
            'choices' => [
                'paper'=>'paper',
                'plastic'=>'plastic',
                'glass'=>'glass',
                'metal'=>'metal',
                'organic waste'=>'organic waste',
            ],
            'placeholder'=>'choose a type'])
            ->add('location')
            ->add('etat', ChoiceType::class,[
                'choices' => [
                    'collected'=>'collected',
                    'not collected'=>'not collected',
                ] ,
                'placeholder'=>'Status',])
                
            ->add('quantite')
            
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Waste::class,
        ]);
    }
    
}