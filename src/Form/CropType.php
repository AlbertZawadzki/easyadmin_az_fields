<?php

namespace EasyAdminAzFields\Form;

use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
use EasyAdminAzFields\Dto\CropperSettingsDto;
use EasyAdminAzFields\Dto\CropperValueDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CropType extends AbstractType
{
    public const string OPTION_DATA_TRANSFORMER = 'dataTransformer';
    public const string OPTION_CROPPER_SETTINGS = 'cropperSettings';

    public function getBlockPrefix(): string
    {
        return 'crop';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dataTransformer = $options[self::OPTION_DATA_TRANSFORMER];

        $builder
            ->add(
                'image',
                FileType::class,
                [
                    'required' => false,
                    'data_class' => null,
                ]
            )
            ->add('oldImage', HiddenType::class)
            ->add('x', HiddenType::class)
            ->add('y', HiddenType::class)
            ->add('width', HiddenType::class)
            ->add('height', HiddenType::class)
            ->addModelTransformer($dataTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $requiredOptions = [
            CropType::OPTION_DATA_TRANSFORMER,
            CropType::OPTION_CROPPER_SETTINGS,
        ];

        $resolver->setDefault('data_class', CropperValueDto::class)
            ->setRequired($requiredOptions)
            ->setAllowedTypes(CropType::OPTION_DATA_TRANSFORMER, CropDataTransformerInterface::class)
            ->setAllowedTypes(CropType::OPTION_CROPPER_SETTINGS, CropperSettingsDto::class);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);
        $view->vars[self::OPTION_CROPPER_SETTINGS] = $options[self::OPTION_CROPPER_SETTINGS];
    }
}
