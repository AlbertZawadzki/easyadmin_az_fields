<?php

namespace EasyAdminAzFields\Tests\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyAdminAzFields\Filter\NestedEntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDto;
use PHPUnit\Framework\TestCase;

class NestedEntityFilterTest extends TestCase
{
    private function makeFilterData(string $property, mixed $value): FilterDataDto
    {
        $filterDto = new FilterDto();
        $filterDto->setProperty($property);

        return FilterDataDto::new(0, $filterDto, 'entity', [
            'comparison' => '=',
            'value' => $value,
        ]);
    }

    private function makeEntityDto(): EntityDto
    {
        return (new \ReflectionClass(EntityDto::class))->newInstanceWithoutConstructor();
    }

    public function testNewReturnsInstance(): void
    {
        $filter = NestedEntityFilter::new('category', \stdClass::class);

        $this->assertInstanceOf(NestedEntityFilter::class, $filter);
    }

    public function testApplyWithSimplePropertyAddsNoJoin(): void
    {
        $filter = NestedEntityFilter::new('status', \stdClass::class);

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('getRootAliases')->willReturn(['entity']);
        $qb->method('getAllAliases')->willReturn(['entity']);
        $qb->method('andWhere')->willReturnSelf();
        $qb->method('setParameter')->willReturnSelf();

        $qb->expects($this->never())->method('leftJoin');
        $qb->expects($this->once())->method('andWhere')
            ->with($this->matchesRegularExpression('/^entity\.status = :/'));
        $qb->expects($this->once())->method('setParameter')
            ->with($this->matchesRegularExpression('/^param_\d+$/'), 'active');

        $filter->apply($qb, $this->makeFilterData('status', 'active'), null, $this->makeEntityDto());
    }

    public function testApplyWithOneNestedLevelAddsOneJoin(): void
    {
        $filter = NestedEntityFilter::new('category.name', \stdClass::class);

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('getRootAliases')->willReturn(['entity']);
        $qb->method('getAllAliases')->willReturn(['entity']);
        $qb->method('leftJoin')->willReturnSelf();
        $qb->method('andWhere')->willReturnSelf();
        $qb->method('setParameter')->willReturnSelf();

        $qb->expects($this->once())->method('leftJoin')
            ->with('entity.category', 'alias_category_0');
        $qb->expects($this->once())->method('andWhere')
            ->with($this->matchesRegularExpression('/^alias_category_0\.name = :/'));

        $filter->apply($qb, $this->makeFilterData('category.name', 'tech'), null, $this->makeEntityDto());
    }

    public function testApplyWithTwoNestedLevelsAddsTwoJoins(): void
    {
        $filter = NestedEntityFilter::new('category.parent.name', \stdClass::class);

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('getRootAliases')->willReturn(['entity']);
        $qb->method('getAllAliases')->willReturn(['entity']);
        $qb->method('leftJoin')->willReturnSelf();
        $qb->method('andWhere')->willReturnSelf();
        $qb->method('setParameter')->willReturnSelf();

        $qb->expects($this->exactly(2))->method('leftJoin');
        $qb->expects($this->once())->method('andWhere')
            ->with($this->matchesRegularExpression('/^alias_parent_1\.name = :/'));

        $filter->apply($qb, $this->makeFilterData('category.parent.name', 'root'), null, $this->makeEntityDto());
    }

    public function testApplySkipsJoinIfAliasAlreadyExists(): void
    {
        $filter = NestedEntityFilter::new('category.name', \stdClass::class);

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('getRootAliases')->willReturn(['entity']);
        // Alias already registered — should not add a second join
        $qb->method('getAllAliases')->willReturn(['entity', 'alias_category_0']);
        $qb->method('andWhere')->willReturnSelf();
        $qb->method('setParameter')->willReturnSelf();

        $qb->expects($this->never())->method('leftJoin');

        $filter->apply($qb, $this->makeFilterData('category.name', 'tech'), null, $this->makeEntityDto());
    }

    public function testApplyPassesFilterValueAsParameter(): void
    {
        $filter = NestedEntityFilter::new('status', \stdClass::class);

        $qb = $this->createMock(QueryBuilder::class);
        $qb->method('getRootAliases')->willReturn(['entity']);
        $qb->method('getAllAliases')->willReturn(['entity']);
        $qb->method('andWhere')->willReturnSelf();
        $qb->method('setParameter')->willReturnSelf();

        $qb->expects($this->once())->method('setParameter')
            ->with($this->anything(), 'published');

        $filter->apply($qb, $this->makeFilterData('status', 'published'), null, $this->makeEntityDto());
    }
}
