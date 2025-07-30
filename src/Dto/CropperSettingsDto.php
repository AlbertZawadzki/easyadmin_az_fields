<?php

namespace EasyAdminAzFields\Dto;

class CropperSettingsDto
{
    private bool $responsive = true;
    private bool $zoomable = true;
    private bool $scalable = true;
    private bool $background = false;
    private ?float $aspectRatio = null;
    private int $viewMode = 1;
    private int $autoCropArea = 1;
    private string $unit = 'px';

    public function isResponsive(): bool
    {
        return $this->responsive;
    }

    public function setResponsive(bool $responsive): CropperSettingsDto
    {
        $this->responsive = $responsive;
        return $this;
    }

    public function isZoomable(): bool
    {
        return $this->zoomable;
    }

    public function setZoomable(bool $zoomable): CropperSettingsDto
    {
        $this->zoomable = $zoomable;
        return $this;
    }

    public function isScalable(): bool
    {
        return $this->scalable;
    }

    public function setScalable(bool $scalable): CropperSettingsDto
    {
        $this->scalable = $scalable;
        return $this;
    }

    public function getAspectRatio(): ?float
    {
        return $this->aspectRatio;
    }

    public function setAspectRatio(?float $aspectRatio): CropperSettingsDto
    {
        $this->aspectRatio = $aspectRatio;
        return $this;
    }

    public function getViewMode(): int
    {
        return $this->viewMode;
    }

    public function setViewMode(int $viewMode): CropperSettingsDto
    {
        $this->viewMode = $viewMode;
        return $this;
    }

    public function getAutoCropArea(): int
    {
        return $this->autoCropArea;
    }

    public function setAutoCropArea(int $autoCropArea): CropperSettingsDto
    {
        $this->autoCropArea = $autoCropArea;
        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): CropperSettingsDto
    {
        $this->unit = $unit;
        return $this;
    }
}