<?php

namespace EasyAdminAzFields\Form;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Contracts\Translation\TranslatableInterface;

final class CoordinatesField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, TranslatableInterface|string|bool|null $label = null): FieldInterface
    {
        return (new self())
            ->setFormType(CoordinatesType::class)
            ->setProperty($propertyName)
            ->setLabel($label ?: $propertyName)
            ->addJsFiles('/bundles/easyadminazfields/vendor/')
            ->addJsFiles('/bundles/easyadminazfields/js/coordinates_field.js')
            ->addFormTheme('@EasyAdminAzFields/coordinates_field.html.twig')
            ->setTemplatePath('@EasyAdminAzFields/coordinates_field.html.twig');
    }
}