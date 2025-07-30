<?php

namespace EasyAdminAzFields\Form;

use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
use EasyAdminAzFields\Dto\CropperSettingsDto;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class CropField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(CropType::class)
            ->addJsFiles('/bundles/easyadminazfields/vendor/cropperjs/cropper.min.js')
            ->addCssFiles('/bundles/easyadminazfields/vendor/cropperjs/cropper.min.css')
            ->addJsFiles('/bundles/easyadminazfields/js/cropper_field.js')
            ->addCssFiles('/bundles/easyadminazfields/css/cropper_field.css')
            ->addFormTheme('@EasyAdminAzFields/crop_field.html.twig');
    }

    public function setDataTransformer(CropDataTransformerInterface $dataTransformer): self
    {
        return $this->setFormTypeOption(CropType::OPTION_DATA_TRANSFORMER, $dataTransformer);
    }

    public function setCropperSettings(CropperSettingsDto $settingsDto): self
    {
        return $this->setFormTypeOption(CropType::OPTION_CROPPER_SETTINGS, $settingsDto);
    }
}
