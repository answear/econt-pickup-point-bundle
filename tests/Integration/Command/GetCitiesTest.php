<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Tests\Integration\Command;

use Answear\EcontBundle\Client\Client;
use Answear\EcontBundle\Client\RequestTransformer;
use Answear\EcontBundle\Client\Serializer;
use Answear\EcontBundle\Command\GetCities;
use Answear\EcontBundle\ConfigProvider;
use Answear\EcontBundle\Request\GetCitiesRequest;
use Answear\EcontBundle\Response\GetCitiesResponse;
use Answear\EcontBundle\Tests\MockGuzzleTrait;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GetCitiesTest extends TestCase
{
    use MockGuzzleTrait;

    private Client $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(new ConfigProvider('test', 'Qwerty123!'), $this->setupGuzzleClient());
    }

    #[Test]
    public function successfulGetCities(): void
    {
        $command = $this->getCommand();
        $this->mockGuzzleResponse(new Response(200, [], $this->getSuccessfulBody()));

        $response = $command->getCities(new GetCitiesRequest('GR'));

        $this->assertCount(1, $response->getCities());
        $this->assertCity($response);
    }

    private function assertCity(GetCitiesResponse $response): void
    {
        $city = $response->getCities()->getIterator()->current();

        $this->assertNotNull($city);
        $this->assertSame($city->id, 204964);
        $this->assertNull($city->country->id);
        $this->assertSame($city->country->code2, 'LU');
        $this->assertSame($city->country->code3, 'LUX');
        $this->assertSame($city->country->name, 'Люксембург');
        $this->assertSame($city->country->nameEn, 'Luxembourg');
        $this->assertTrue($city->country->isEU);
        $this->assertSame($city->postalCode, '0');
        $this->assertSame($city->name, 'LUXEMBOURG');
        $this->assertSame($city->nameEn, 'LUXEMBOURG');
        $this->assertSame($city->phoneCode, '0');
        $this->assertFalse($city->expressDeliveries);
        $this->assertNull($city->coordinates);
    }

    private function getCommand(): GetCities
    {
        $transformer = new RequestTransformer(new Serializer());

        return new GetCities($this->client, $transformer);
    }

    private function getSuccessfulBody(): string
    {
        return file_get_contents(__DIR__ . '/data/example.getCitiesResponse.json');
    }
}
