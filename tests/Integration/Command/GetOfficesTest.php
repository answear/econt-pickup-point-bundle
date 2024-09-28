<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Tests\Integration\Command;

use Answear\EcontBundle\Client\Client;
use Answear\EcontBundle\Client\RequestTransformer;
use Answear\EcontBundle\Client\Serializer;
use Answear\EcontBundle\Command\GetOffices;
use Answear\EcontBundle\ConfigProvider;
use Answear\EcontBundle\Exception\MalformedResponseException;
use Answear\EcontBundle\Request\GetOfficesRequest;
use Answear\EcontBundle\Response\GetOfficesResponse;
use Answear\EcontBundle\Response\Struct\OpeningHours;
use Answear\EcontBundle\Tests\MockGuzzleTrait;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GetOfficesTest extends TestCase
{
    use MockGuzzleTrait;

    private Client $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(new ConfigProvider('test', 'Qwerty123!'), $this->setupGuzzleClient());
    }

    #[Test]
    public function successfulGetOffices(): void
    {
        $command = $this->getCommand();
        $this->mockGuzzleResponse(new Response(200, [], $this->getSuccessfulBody()));

        $response = $command->getOffices(new GetOfficesRequest());

        $this->assertCount(1, $response->getOffices());
        $this->assertOffice($response);
    }

    #[Test]
    public function getOfficeWithEmptyCoordinates(): void
    {
        $command = $this->getCommand();
        $this->mockGuzzleResponse(new Response(200, [], $this->getBodyWithEmptyCoords()));

        $response = $command->getOffices(new GetOfficesRequest());
        $office = $response->getOffices()->getIterator()->current();

        $this->assertNotNull($office);
        $this->assertSame($office->id, 33701);
        $this->assertNull($office->address->coordinates);
    }

    #[Test]
    public function responseWithError(): void
    {
        $this->expectException(MalformedResponseException::class);
        $this->expectExceptionMessage('Error response');

        $command = $this->getCommand();
        $this->mockGuzzleResponse(new Response(200, [], $this->getErrorBody()));

        $response = $command->getOffices(new GetOfficesRequest('', 90));

        $this->assertCount(0, $response->getOffices());
        $this->assertOffice($response);
    }

    private function assertOffice(GetOfficesResponse $response): void
    {
        $office = $response->getOffices()->getIterator()->current();

        $this->assertNotNull($office);
        $this->assertSame($office->id, 33701);
        $this->assertSame($office->code, '15774');
        $this->assertFalse($office->isMPS);
        $this->assertFalse($office->isAPS);
        $this->assertSame($office->name, 'ACS AFTHIMERON ATTIKIS');
        $this->assertSame($office->nameEn, 'ACS AFTHIMERON ATTIKIS');
        $this->assertSame($office->phones, ['2107714680']);
        $this->assertSame($office->emails, ['shops@acscourier.gr']);
        $this->assertNull($office->address->id);
        $this->assertSame($office->address->city->id, 55978);
        $this->assertSame($office->address->city->country->id, 1084);
        $this->assertSame($office->address->city->country->code2, 'GR');
        $this->assertSame($office->address->city->country->code3, 'GRC');
        $this->assertSame($office->address->city->country->name, 'Гърция');
        $this->assertSame($office->address->city->country->nameEn, 'Greece');
        $this->assertTrue($office->address->city->country->isEU);
        $this->assertSame($office->address->city->postalCode, '10431');
        $this->assertSame($office->address->city->name, 'Αθήνα');
        $this->assertSame($office->address->city->nameEn, 'ATHINA');
        $this->assertNull($office->address->city->phoneCode);
        $this->assertNull($office->address->city->expressDeliveries);
        $this->assertSame($office->address->fullAddress, ' Αθήνα Bairaktari 15');
        $this->assertSame($office->address->num, '');
        $this->assertSame($office->address->other, 'Bairaktari 15');
        $this->assertSame($office->address->coordinates->latitude, 37.983696666667);
        $this->assertSame($office->address->coordinates->longitude, 23.771268333333);
        $this->assertSame($office->info, '');
        $this->assertSame($office->currency, 'EUR');
        $this->assertNull($office->language);
        $this->assertEquals($office->openingHours, new OpeningHours(1627534800000, 1627578000000));
        $this->assertEquals($office->halfDayOpeningHours, new OpeningHours(1627538400000, 1627552800000));
        $this->assertSame($office->partnerCode, 'ACS');
        $this->assertSame($office->hubCode, '500906');
        $this->assertSame($office->hubName, 'ACS Greece');
        $this->assertSame($office->hubNameEn, 'ACS Greece');
    }

    private function getCommand(): GetOffices
    {
        $transformer = new RequestTransformer(new Serializer());

        return new GetOffices($this->client, $transformer);
    }

    private function getSuccessfulBody(): string
    {
        return file_get_contents(__DIR__ . '/data/example.getOfficesResponse.json');
    }

    private function getBodyWithEmptyCoords(): string
    {
        return file_get_contents(__DIR__ . '/data/example.getOfficesResponseWithEmptyCoords.json');
    }

    private function getErrorBody(): string
    {
        return \json_encode(
            [
                'error' => [
                    'type' => 'unknown',
                    'message' => 'unknown',
                    'fields' => ['unknown'],
                    'innerErrors' => null,
                ],
            ],
            JSON_THROW_ON_ERROR
        );
    }
}
