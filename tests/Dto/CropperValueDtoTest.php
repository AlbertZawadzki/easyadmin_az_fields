<?php

namespace EasyAdminAzFields\Tests\Dto;

use EasyAdminAzFields\Dto\CropperValueDto;
use PHPUnit\Framework\TestCase;

class CropperValueDtoTest extends TestCase
{
    public function testDefaults(): void
    {
        $dto = new CropperValueDto();

        $this->assertNull($dto->getImage());
        $this->assertNull($dto->getOldImage());
        $this->assertSame(0, $dto->getX());
        $this->assertSame(0, $dto->getY());
        $this->assertSame(0, $dto->getWidth());
        $this->assertSame(0, $dto->getHeight());
    }

    public function testSettersReturnSelf(): void
    {
        $dto = new CropperValueDto();

        $this->assertSame($dto, $dto->setImage('img.png'));
        $this->assertSame($dto, $dto->setOldImage('old.png'));
        $this->assertSame($dto, $dto->setX(10));
        $this->assertSame($dto, $dto->setY(20));
        $this->assertSame($dto, $dto->setWidth(100));
        $this->assertSame($dto, $dto->setHeight(200));
    }

    public function testSetAndGet(): void
    {
        $dto = (new CropperValueDto())
            ->setImage('new.jpg')
            ->setOldImage('prev.jpg')
            ->setX(5)
            ->setY(15)
            ->setWidth(300)
            ->setHeight(150);

        $this->assertSame('new.jpg', $dto->getImage());
        $this->assertSame('prev.jpg', $dto->getOldImage());
        $this->assertSame(5, $dto->getX());
        $this->assertSame(15, $dto->getY());
        $this->assertSame(300, $dto->getWidth());
        $this->assertSame(150, $dto->getHeight());
    }

    public function testNullableImageFields(): void
    {
        $dto = (new CropperValueDto())
            ->setImage('img.png')
            ->setOldImage('old.png');

        $dto->setImage(null);
        $dto->setOldImage(null);

        $this->assertNull($dto->getImage());
        $this->assertNull($dto->getOldImage());
    }
}
