<?php

namespace App\Form;

use App\Entity\Mission;
use App\Entity\Planification;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PlanificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_driver',null, [
                'attr' => [
                    'placeholder' => 'Mission',
                ]])
            ->add('date',DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\GreaterThan('today')
                ],
            ])
            ->add('mission',null, [
                'attr' => [
                    'placeholder' => 'Mission',
                ]])
            
           
            
        ;
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
        
            if ($data->getMission()) {
                $mission = $form->get('mission')->getData();
                if ($mission) {
                    $data->setLocation($mission->getLocation());
                }
            }
        });
        
        
       
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planification::class,
        ]);
    }
}
