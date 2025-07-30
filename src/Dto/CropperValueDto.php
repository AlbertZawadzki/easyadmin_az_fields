<?php

namespace EasyAdminAzFields\Dto;

class CropperValueDto
{
    private ?string $image = null;
    private ?string $oldImage = null;
    private int $x = 0;
    private int $y = 0;
    private int $width = 0;
    private int $height = 0;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): CropperValueDto
    {
        $this->image = $image;
        return $this;
    }

    public function getOldImage(): ?string
    {
        return $this->oldImage;
    }

    public function setOldImage(?string $oldImage): CropperValueDto
    {
        $this->oldImage = $oldImage;
        return $this;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): CropperValueDto
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): CropperValueDto
    {
        $this->y = $y;
        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): CropperValueDto
    {
        $this->width = $width;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): CropperValueDto
    {
        $this->height = $height;
        return $this;
    }
}