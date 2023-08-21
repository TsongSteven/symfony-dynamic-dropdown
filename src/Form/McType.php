<?php

namespace App\Form;

use App\Entity\Mc;
use App\Entity\Location;
use App\Entity\Region;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\Property;
use App\Entity\Population;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class McType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('family')
            ->add('pg')
            ->add('hostel')
            ->add('hotel')
            ->add('restaurant')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return $category->getName();
                }
            ])
            ->add('unit', ChoiceType::class, [
                'choices' => [
                    'Kilo Gram' => 'kg',
                    'Litre' => 'litre',
                    'Tonne' => 'tonne',
                    'Dozen' => 'dozen'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => Mc::class,
        ]);
    }
}
