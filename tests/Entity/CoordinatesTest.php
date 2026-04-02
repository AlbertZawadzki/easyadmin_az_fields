<?php

namespace EasyAdminAzFields\Tests\Entity;

use EasyAdminAzFields\Entity\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase
{
    public function testDefaultConstructor(): void
    {
        $coords = new Coordinates();

        $this->assertNull($coords->getLatitude());
        $this->assertNull($coords->getLongitude());
    }

    public function testConstructorWithValues(): void
    {
        $coords = new Coordinates(52.2297, 21.0122);

        $this->assertSame(52.2297, $coords->getLatitude());
        $this->assertSame(21.0122, $coords->getLongitude());
    }

    public function testSettersReturnSelf(): void
    {
        $coords = new Coordinates();

        $this->assertSame($coords, $coords->setLatitude(52.2297));
        $this->assertSame($coords, $coords->setLongitude(21.0122));
    }

    public function testSetAndGet(): void
    {
        $coords = (new Coordinates())
            ->setLatitude(48.8566)
            ->setLongitude(2.3522);

        $this->assertSame(48.8566, $coords->getLatitude());
        $this->assertSame(2.3522, $coords->getLongitude());
    }

    public function testNullableValues(): void
    {
        $coords = new Coordinates(1.0, 2.0);
        $coords->setLatitude(null)->setLongitude(null);

        $this->assertNull($coords->getLatitude());
        $this->assertNull($coords->getLongitude());
    }

    public function testToString(): void
    {
        $coords = new Coordinates();

        $this->assertSame('You have not imported the files!', (string) $coords);
    }
}
