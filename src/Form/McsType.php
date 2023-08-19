<?php

namespace App\Form;

use App\Entity\Location;
use App\Form\McType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class McsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mcs', CollectionType::class, [
                'entry_type'=> McType::class,
                'label' => false,
                'entry_options' => ['label' => false ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => '',
        ]);
    }
}
