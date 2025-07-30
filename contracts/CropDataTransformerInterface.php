<?php

namespace EasyAdminAzFields\Contracts;

use EasyAdminAzFields\Dto\CropperValueDto;
use Symfony\Component\Form\DataTransformerInterface;

interface CropDataTransformerInterface extends DataTransformerInterface
{
    public function transform(mixed $value): CropperValueDto;

    /** @param CropperValueDto $value */
    public function reverseTransform(mixed $value);
}
