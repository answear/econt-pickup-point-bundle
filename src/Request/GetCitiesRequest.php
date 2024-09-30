<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Request;

class GetCitiesRequest extends Request
{
    private const ENDPOINT = 'NomenclaturesService.getCities.json';
    private const HTTP_METHOD = 'POST';

    public function __construct(
        private ?string $countryCode = null,
    ) {
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
