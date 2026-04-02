<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Entity\Coordinates;
use EasyAdminAzFields\Form\CoordinatesType;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Test\TypeTestCase;

#[AllowMockObjectsWithoutExpectations]
class CoordinatesTypeTest extends TypeTestCase
{
    public function testGetBlockPrefix(): void
    {
        $type = new CoordinatesType();

        $this->assertSame('coordinates', $type->getBlockPrefix());
    }

    public function testFormHasLatitudeAndLongitudeChildren(): void
    {
        $form = $this->factory->create(CoordinatesType::class);

        $this->assertTrue($form->has('latitude'));
        $this->assertTrue($form->has('longitude'));
    }

    public function testChildrenAreNumberType(): void
    {
        $form = $this->factory->create(CoordinatesType::class);

        $this->assertInstanceOf(NumberType::class, $form->get('latitude')->getConfig()->getType()->getInnerType());
        $this->assertInstanceOf(NumberType::class, $form->get('longitude')->getConfig()->getType()->getInnerType());
    }

    public function testChildrenAreNotRequired(): void
    {
        $form = $this->factory->create(CoordinatesType::class);

        $this->assertFalse($form->get('latitude')->getConfig()->getOption('required'));
        $this->assertFalse($form->get('longitude')->getConfig()->getOption('required'));
    }

    public function testDataClassIsCoordinates(): void
    {
        $form = $this->factory->create(CoordinatesType::class);

        $this->assertSame(Coordinates::class, $form->getConfig()->getOption('data_class'));
    }

    public function testSubmitValidData(): void
    {
        $form = $this->factory->create(CoordinatesType::class);
        $form->submit(['latitude' => '52.2297', 'longitude' => '21.0122']);

        $this->assertTrue($form->isValid());
        $data = $form->getData();
        $this->assertInstanceOf(Coordinates::class, $data);
        $this->assertEqualsWithDelta(52.2297, $data->getLatitude(), 0.0001);
        $this->assertEqualsWithDelta(21.0122, $data->getLongitude(), 0.0001);
    }

    public function testSubmitEmptyData(): void
    {
        $form = $this->factory->create(CoordinatesType::class);
        $form->submit(['latitude' => '', 'longitude' => '']);

        $this->assertTrue($form->isValid());
    }
}
