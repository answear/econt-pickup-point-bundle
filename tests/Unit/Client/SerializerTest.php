<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Tests\Unit\Client;

use Answear\EcontBundle\Client\Serializer;
use Answear\EcontBundle\Request\GetOfficesRequest;
use Answear\EcontBundle\Request\Request;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SerializerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    #[DataProvider('provider')]
    public function bodySerialization(Request $request, string $expectedBody): void
    {
        $serializer = new Serializer();

        $this->assertSame($expectedBody, $serializer->serialize($request));
    }

    public static function provider(): iterable
    {
        yield 'requestFields' => [
            new GetOfficesRequest('GR', 1),
            '{"countryCode":"GR","cityID":1}',
        ];

        yield 'skipNullValues' => [
            new GetOfficesRequest('GR', null),
            '{"countryCode":"GR"}',
        ];
    }
}
