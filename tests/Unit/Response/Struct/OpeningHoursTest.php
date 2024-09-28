<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Tests\Unit\Response\Struct;

use Answear\EcontBundle\Response\Struct\OpeningHours;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OpeningHoursTest extends TestCase
{
    #[Test]
    #[DataProvider('provider')]
    public function validTransformation(int $from, int $to, string $expectedFrom, string $expectedTo): void
    {
        $openingHours = new OpeningHours($from, $to);

        $this->assertInstanceOf(\DateTimeInterface::class, $openingHours->from);
        $this->assertInstanceOf(\DateTimeInterface::class, $openingHours->to);
        $this->assertEquals($expectedFrom, $openingHours->from->format('Y-m-d H:i'));
        $this->assertEquals($expectedTo, $openingHours->to->format('Y-m-d H:i'));
    }

    public static function provider(): iterable
    {
        yield 'normal hours' => [1627534800000, 1627578000000, '2021-07-29 05:00', '2021-07-29 17:00'];
        yield 'half day hours' => [1627538400000, 1627552800000, '2021-07-29 06:00', '2021-07-29 10:00'];
    }
}
