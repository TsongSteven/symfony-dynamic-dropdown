<?php

namespace App\Form;

use App\Entity\Mc;
use App\Entity\Location;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('location', EntityType::class, [
                'label' => 'For The Location',
                'class' => Location::class,
                'choice_label' => function (Location $location) {
                    return $location->getName();
                }
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
