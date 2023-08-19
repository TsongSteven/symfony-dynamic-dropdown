<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\District;
use App\Entity\Village;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product_name')
            ->add('size')
            ->add('unit', ChoiceType::class, [
                'label' => 'Unit of Product',
                'choices' => [
                    'Kg' => 'Kilo Gram',
                    'Quintal' => 'Quintal',
                    'Tonne' => 'Tonne'
                ],
                'mapped' => false
            ])
            ->add('district', EntityType::class, [
                'class' => District::class,
                'choice_label' => function (District $district) {
                    return $district->getDistrictName();
                },
                'choice_value' => 'id'
            ])
        ;

        $formModifier = function (FormInterface $form, District  $district  = null): void {
            $positions = null === $district ? [] : $district->getVillages();

            $form->add('village', EntityType::class, [
                'class' => Village::class,
                'placeholder' => '',
                'choices' => $positions,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getDistrict());
            }
        );

        $builder->get('district')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $district = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $district);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
