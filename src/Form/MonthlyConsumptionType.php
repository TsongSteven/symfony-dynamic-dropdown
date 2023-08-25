<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\Property;
use App\Entity\MonthlyConsumption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class MonthlyConsumptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight', TextType::class, [
                'label' => 'Measure',
            ])
            ->add('unit', ChoiceType::class, [
                'choices' =>[
                    'Kilo Gram' => 'kg',
                    'Litre' =>'litre',
                    'Pouch' => 'pouch',
                    'Dozen' => 'dozen',
                ]
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => function (Location $location) {
                    return $location->getName();
                }
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => 'Select Category',
                'choice_label' => 'name',
            ])
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'label' => 'Consumer',
                'choice_label' => function (Property $property) {
                    return $property->getName();
                }
            ])
        ;

        $formModifier = function (FormInterface $form, Category $category = null) {

            $subCategories = null === $category ? [] : $category->getSubCategories();
            $form->add('sub_category', EntityType::class, [
                'class' => SubCategory::class,
                'choices' => $subCategories,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getCategory());
            }
        );
        $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $category = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $category);
            }
        );
        // $builder->setAction($options['action']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MonthlyConsumption::class,
        ]);
    }
}
