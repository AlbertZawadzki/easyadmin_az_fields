<?php

namespace EasyAdminAzFields\Tests\Form;

use EasyAdminAzFields\Form\CoordinatesField;
use EasyAdminAzFields\Form\CoordinatesType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use PHPUnit\Framework\TestCase;

class CoordinatesFieldTest extends TestCase
{
    public function testNewReturnsFieldInterface(): void
    {
        $field = CoordinatesField::new('location');

        $this->assertInstanceOf(FieldInterface::class, $field);
    }

    public function testNewSetsFormType(): void
    {
        $field = CoordinatesField::new('location');

        $this->assertSame(CoordinatesType::class, $field->getAsDto()->getFormType());
    }

    public function testNewSetsProperty(): void
    {
        $field = CoordinatesField::new('location');

        $this->assertSame('location', $field->getAsDto()->getProperty());
    }

    public function testLabelDefaultsToPropertyName(): void
    {
        $field = CoordinatesField::new('location');

        $this->assertSame('location', $field->getAsDto()->getLabel());
    }

    public function testCustomLabelIsUsed(): void
    {
        $field = CoordinatesField::new('location', 'GPS Position');

        $this->assertSame('GPS Position', $field->getAsDto()->getLabel());
    }
}
