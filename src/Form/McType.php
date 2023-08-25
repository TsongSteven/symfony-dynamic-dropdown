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
            ->add('family',TextType::class)
            ->add('pg',TextType::class)
            ->add('hostel',TextType::class)
            ->add('hotel',TextType::class)
            ->add('restaurant',TextType::class)
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
                    'Pouch(1 Ltr)' => 'pouch1ltr',
                    'Packet(1 Kg)' => 'packet1kg',
                    'Packet(5 Kg)' => 'packet5kg',
                    'Tonne' => 'tonne',
                    'Bag(30 Kg)' => 'bag30kg',
                    'Bag(50 Kg)' => 'bag50kg'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mc::class,
        ]);
    }
}
