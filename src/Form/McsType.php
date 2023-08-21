<?php

namespace App\Form;

use App\Entity\Location;
use App\Form\McType;
use App\Entity\Region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class McsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('region', EntityType::class,[
                'placeholder' => 'Please select the Region.',
                'label' => false,
                'class' => Region::class,
                'choice_label' => function(Region $region){
                    return $region->getName();
                }
            ])
            ->add('mcs', CollectionType::class, [
                'entry_type'=> McType::class,
                'label' => false,
                'entry_options' => ['label' => false ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                
            ])
            ->add('family_count', TextType::class, [ 
                'label' => 'Nos. of Family', 
                'required' => false, 
            ])
            ->add('pg_count', TextType::class, [ 
                'label' => 'Nos. of Pg', 
                'required' => false, 
            ])
            ->add('hostel_count', TextType::class, [ 
                'label' => 'Nos. of Hostel', 
                'required' => false, 
            ])
            ->add('hotel_count', TextType::class, [ 
                'label' => 'Nos. of Hotel', 
                'required' => false, 
            ])
            ->add('restaurant_count', TextType::class, [ 
                'label' => 'Nos. of Restaurant', 
                'required' => false, 
            ])
            ;
        ;

        $formModifier = function(FormInterface $form, Region $region = null){
            $locations = null === $region ? [] : $region->getLocation();
            $form->add('location', EntityType::class, [
                'label' => false,
                'class' => Location::class,
                'choices' => $locations,
            ]);
        };       
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formModifier){
                $data = $event->getData();
                $region = null;
        
                if ($data instanceof Mc) {
                    $region = $data->getRegion();
                }
                
                $formModifier($event->getForm(), $region);
        });

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier){
                $region = $event->getForm()->getData();
    
                $formModifier($event->getForm()->getParent(), $region);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => '',
        ]);
    }
}
