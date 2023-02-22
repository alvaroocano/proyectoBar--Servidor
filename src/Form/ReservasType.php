<?php

namespace App\Form;

use App\Entity\Reservas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('hora')
            ->add('nro_personas')
            ->add('primero')
            ->add('segundo')
            ->add('bebida')
            ->add('postre')
            ->add('total')
            ->add('restaurantes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservas::class,
        ]);
    }
}
