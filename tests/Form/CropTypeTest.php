<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Contracts\CropDataTransformerInterface;
use EasyAdminAzFields\Dto\CropperSettingsDto;
use EasyAdminAzFields\Dto\CropperValueDto;
use EasyAdminAzFields\Form\CropType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use Symfony\Component\Form\Test\TypeTestCase;

#[AllowMockObjectsWithoutExpectations]
class CropTypeTest extends TypeTestCase
{
    private CropDataTransformerInterface $transformer;
    private CropperSettingsDto $settings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transformer = $this->createStub(CropDataTransformerInterface::class);
        $this->transformer->method('transform')->willReturn(new CropperValueDto());

        $this->settings = new CropperSettingsDto();
    }

    private function createCropForm(array $options = []): \Symfony\Component\Form\FormInterface
    {
        return $this->factory->create(CropType::class, new CropperValueDto(), array_merge([
            CropType::OPTION_DATA_TRANSFORMER => $this->transformer,
            CropType::OPTION_CROPPER_SETTINGS => $this->settings,
        ], $options));
    }

    public function testGetBlockPrefix(): void
    {
        $type = new CropType();

        $this->assertSame('crop', $type->getBlockPrefix());
    }

    public function testFormHasExpectedChildren(): void
    {
        $form = $this->createCropForm();

        $this->assertTrue($form->has('image'));
        $this->assertTrue($form->has('oldImage'));
        $this->assertTrue($form->has('x'));
        $this->assertTrue($form->has('y'));
        $this->assertTrue($form->has('width'));
        $this->assertTrue($form->has('height'));
    }

    public function testImageChildIsFileType(): void
    {
        $form = $this->createCropForm();

        $this->assertInstanceOf(
            FileType::class,
            $form->get('image')->getConfig()->getType()->getInnerType()
        );
    }

    public function testHiddenFieldsAreHiddenType(): void
    {
        $form = $this->createCropForm();

        foreach (['oldImage', 'x', 'y', 'width', 'height'] as $field) {
            $this->assertInstanceOf(
                HiddenType::class,
                $form->get($field)->getConfig()->getType()->getInnerType(),
                "Expected $field to be HiddenType"
            );
        }
    }

    public function testImageChildIsNotRequired(): void
    {
        $form = $this->createCropForm();

        $this->assertFalse($form->get('image')->getConfig()->getOption('required'));
    }

    public function testBuildViewSetsCropperSettings(): void
    {
        $settings = (new CropperSettingsDto())
            ->setAspectRatio(16 / 9)
            ->setViewMode(2);

        $view = $this->createCropForm([
            CropType::OPTION_CROPPER_SETTINGS => $settings,
        ])->createView();

        $this->assertSame($settings, $view->vars[CropType::OPTION_CROPPER_SETTINGS]);
    }

    public function testMissingDataTransformerThrowsException(): void
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\MissingOptionsException::class);

        $this->factory->create(CropType::class, null, [
            CropType::OPTION_CROPPER_SETTINGS => $this->settings,
        ]);
    }

    public function testMissingCropperSettingsThrowsException(): void
    {
        $this->expectException(\Symfony\Component\OptionsResolver\Exception\MissingOptionsException::class);

        $this->factory->create(CropType::class, null, [
            CropType::OPTION_DATA_TRANSFORMER => $this->transformer,
        ]);
    }
}
