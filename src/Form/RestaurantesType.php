<?php

namespace App\Form;

use App\Entity\Restaurantes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('localidad', TextType::class)
            ->add('horario', TextType::class)
            ->add('telefono', IntegerType::class)
            ->add('aforo', IntegerType::class)
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