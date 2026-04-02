<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
use EasyAdminAzFields\Dto\CropperSettingsDto;
use EasyAdminAzFields\Form\CropField;
use EasyAdminAzFields\Form\CropType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use PHPUnit\Framework\TestCase;

class CropFieldTest extends TestCase
{
    public function testNewReturnsFieldInterface(): void
    {
        $field = CropField::new('photo');

        $this->assertInstanceOf(FieldInterface::class, $field);
    }

    public function testNewSetsFormType(): void
    {
        $field = CropField::new('photo');

        $this->assertSame(CropType::class, $field->getAsDto()->getFormType());
    }

    public function testNewSetsProperty(): void
    {
        $field = CropField::new('photo');

        $this->assertSame('photo', $field->getAsDto()->getProperty());
    }

    public function testNewSetsLabel(): void
    {
        $field = CropField::new('photo', 'Profile Picture');

        $this->assertSame('Profile Picture', $field->getAsDto()->getLabel());
    }

    public function testSetDataTransformerReturnsSelf(): void
    {
        $field = CropField::new('photo');
        $transformer = $this->createStub(CropDataTransformerInterface::class);

        $result = $field->setDataTransformer($transformer);

        $this->assertSame($field, $result);
    }

    public function testSetDataTransformerStoresOption(): void
    {
        $field = CropField::new('photo');
        $transformer = $this->createStub(CropDataTransformerInterface::class);
        $field->setDataTransformer($transformer);

        $options = $field->getAsDto()->getFormTypeOptions();

        $this->assertSame($transformer, $options[CropType::OPTION_DATA_TRANSFORMER]);
    }

    public function testSetCropperSettingsReturnsSelf(): void
    {
        $field = CropField::new('photo');
        $settings = new CropperSettingsDto();

        $result = $field->setCropperSettings($settings);

        $this->assertSame($field, $result);
    }

    public function testSetCropperSettingsStoresOption(): void
    {
        $field = CropField::new('photo');
        $settings = new CropperSettingsDto();
        $field->setCropperSettings($settings);

        $options = $field->getAsDto()->getFormTypeOptions();

        $this->assertSame($settings, $options[CropType::OPTION_CROPPER_SETTINGS]);
    }
}
