<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Request;

class GetOfficesRequest extends Request
{
    private const ENDPOINT = 'NomenclaturesService.getOffices.json';
    private const HTTP_METHOD = 'POST';

    public function __construct(
        private ?string $countryCode = null,
        private ?int $cityID = null,
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
