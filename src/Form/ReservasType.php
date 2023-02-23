<?php

namespace App\Form;

use App\Entity\Reservas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                    'Escoja el primer plato' => '0',
                    'Sopa Castellana' => 'sopa',
                    'Callos a la madrileña' => 'callos',
                    'Cachopo Asturiano' => 'cachopo',
                ],
            ])
            ->add('segundo', ChoiceType::class, [
                'choices'  => [
                    'Escoja el segundo plato' => '0',
                    'Pollo a la jardinera' => 'pollo',
                    'Albóndigas con patatas' => 'albondigas',
                    'Butifarra de vic a la brasa' => 'butifarra',
                ],
            ])
            ->add('bebida', ChoiceType::class, [
                'choices'  => [
                    'Escoja la bebida' => '0',
                    'Agua' => 'agua',
                    'Vino' => 'vino',
                    'Cerveza' => 'cerveza',
                    'Refresco' => 'refresco',
                ],
            ])
            ->add('postre', ChoiceType::class, [
                'choices'  => [
                    'Escoja el postre' => '0',
                    'Arroz con leche' => 'arroz',
                    'Tarta de queso' => 'tartaQueso',
                    'Tarta de la abuela' => 'tartAbuela',
                    'Fruta' => 'fruta',
                ],
            ])
            ->add('total', NumberType::class)
            ->add('restaurantes')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservas::class,
        ]);
    }
}
