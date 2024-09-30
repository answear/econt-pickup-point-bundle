<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Command;

use Answear\EcontBundle\Client\Client;
use Answear\EcontBundle\Client\RequestTransformer;
use Answear\EcontBundle\Request\GetCitiesRequest;
use Answear\EcontBundle\Response\GetCitiesResponse;

readonly class GetCities extends AbstractCommand
{
    public function __construct(
        private Client $client,
        private RequestTransformer $transformer)
    {
    }

    public function getCities(GetCitiesRequest $request): GetCitiesResponse
    {
        $httpRequest = $this->transformer->transform($request);
        $response = $this->client->request($httpRequest);

        $body = $this->getBody($response);

        return GetCitiesResponse::fromArray($body);
    }
}
