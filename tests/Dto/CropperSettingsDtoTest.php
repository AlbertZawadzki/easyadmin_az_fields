<?php

namespace EasyAdminAzFields\Tests\Dto;

use EasyAdminAzFields\Dto\CropperSettingsDto;
use PHPUnit\Framework\TestCase;

class CropperSettingsDtoTest extends TestCase
{
    public function testDefaults(): void
    {
        $dto = new CropperSettingsDto();

        $this->assertTrue($dto->isResponsive());
        $this->assertTrue($dto->isZoomable());
        $this->assertTrue($dto->isScalable());
        $this->assertNull($dto->getAspectRatio());
        $this->assertSame(1, $dto->getViewMode());
        $this->assertSame(1, $dto->getAutoCropArea());
        $this->assertSame('px', $dto->getUnit());
    }

    public function testSettersReturnSelf(): void
    {
        $dto = new CropperSettingsDto();

        $this->assertSame($dto, $dto->setResponsive(false));
        $this->assertSame($dto, $dto->setZoomable(false));
        $this->assertSame($dto, $dto->setScalable(false));
        $this->assertSame($dto, $dto->setAspectRatio(1.5));
        $this->assertSame($dto, $dto->setViewMode(2));
        $this->assertSame($dto, $dto->setAutoCropArea(80));
        $this->assertSame($dto, $dto->setUnit('%'));
    }

    public function testSetAndGet(): void
    {
        $dto = (new CropperSettingsDto())
            ->setResponsive(false)
            ->setZoomable(false)
            ->setScalable(false)
            ->setAspectRatio(16 / 9)
            ->setViewMode(2)
            ->setAutoCropArea(80)
            ->setUnit('%');

        $this->assertFalse($dto->isResponsive());
        $this->assertFalse($dto->isZoomable());
        $this->assertFalse($dto->isScalable());
        $this->assertEqualsWithDelta(16 / 9, $dto->getAspectRatio(), 0.0001);
        $this->assertSame(2, $dto->getViewMode());
        $this->assertSame(80, $dto->getAutoCropArea());
        $this->assertSame('%', $dto->getUnit());
    }

    public function testNullableAspectRatio(): void
    {
        $dto = (new CropperSettingsDto())->setAspectRatio(1.5);
        $dto->setAspectRatio(null);

        $this->assertNull($dto->getAspectRatio());
    }
}
