<?php

namespace EasyAdminAzFields\Form;

use EasyAdminAzFields\Entity\Coordinates;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoordinatesType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'coordinates';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('latitude', NumberType::class, ['required' => false])
            ->add('longitude', NumberType::class, ['required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coordinates::class,
        ]);
    }
}
