<?php

namespace App\Form;

use App\Entity\Restaurantes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('localidad')
            ->add('horario')
            ->add('telefono')
            ->add('aforo')
            ->add('inventarios')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurantes::class,
        ]);
    }
}
