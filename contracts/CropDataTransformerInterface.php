<?php

namespace EasyAdminAzFields\Contracts;

use EasyAdminAzFields\Dto\CropperValueDto;
use Symfony\Component\Form\DataTransformerInterface;

interface CropDataTransformerInterface extends DataTransformerInterface
{
    /** @return CropperValueDto */
    public function transform(mixed $value): mixed;

    /** @param CropperValueDto $value */
    public function reverseTransform(mixed $value): mixed;
}
