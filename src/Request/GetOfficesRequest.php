<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Request;

class GetOfficesRequest extends Request
{
    private const ENDPOINT = 'NomenclaturesService.getOffices.json';
    private const HTTP_METHOD = 'POST';

    private ?string $countryCode;
    private ?int $cityID;

    public function __construct(?string $countryCode = null, ?int $cityId = null)
    {
        $this->countryCode = $countryCode;
        $this->cityID = $cityId;
    }

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    public function getMethod(): string
    {
        return self::HTTP_METHOD;
    }
}
