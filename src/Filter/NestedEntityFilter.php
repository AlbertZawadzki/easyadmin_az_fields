<?php

namespace EasyAdminAzFields\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

final class NestedEntityFilter implements FilterInterface
{
    use FilterTrait;

    private string $propertyPath;

    public static function new(string $formFieldName, string $propertyPath, string $targetEntityClass, ?string $label = null): self
    {
        $filter = new self();
        $filter->propertyPath = $propertyPath;

        return $filter
            ->setFilterFqcn(__CLASS__)
            ->setProperty($formFieldName)
            ->setLabel($label)
            ->setFormType(EntityType::class)
            ->setFormTypeOption('class', $targetEntityClass);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];

        $pathParts = explode('.', $this->propertyPath);
        $lastProperty = array_pop($pathParts);
        $currentAlias = $rootAlias;

        foreach ($pathParts as $i => $property) {
            $newAlias = 'alias_' . $property . '_' . $i;
            if (!in_array($newAlias, $queryBuilder->getAllAliases(), true)) {
                $queryBuilder->leftJoin("$currentAlias.$property", $newAlias);
            }
            $currentAlias = $newAlias;
        }

        $parameterName = 'param_' . rand();
        $queryBuilder
            ->andWhere("$currentAlias.$lastProperty = :$parameterName")
            ->setParameter($parameterName, $filterDataDto->getValue());
    }
}