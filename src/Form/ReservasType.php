<?php

namespace App\Form;

use App\Entity\Reservas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class)
            ->add('hora', TextType::class)
            ->add('nro_personas', IntegerType::class)
            ->add('primero', ChoiceType::class, [
                'choices'  => [
                    'Sopa Castellana' => 'sopa',
                    'Callos a la madrileña' => 'callos',
                    'Cachopo Asturiano' => 'cachopo',
                ],
            ])
            ->add('segundo', ChoiceType::class, [
                'choices'  => [
                    'Pollo a la jardinera' => 'pollo',
                    'Albóndigas con patatas' => 'albondigas',
                    'Butifarra de vic a la brasa' => 'butifarra',
                ],
            ])
            ->add('bebida', ChoiceType::class, [
                'choices'  => [
                    'Agua' => 'agua',
                    'Vino' => 'vino',
                    'Cerveza' => 'cerveza',
                    'Refresco' => 'refresco',
                ],
            ])
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
