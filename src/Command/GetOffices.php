<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Command;

use Answear\EcontBundle\Client\Client;
use Answear\EcontBundle\Client\RequestTransformer;
use Answear\EcontBundle\Request\GetOfficesRequest;
use Answear\EcontBundle\Response\GetOfficesResponse;

readonly class GetOffices extends AbstractCommand
{
    public function __construct(
        private Client $client,
        private RequestTransformer $transformer)
    {
    }

    public function getOffices(GetOfficesRequest $request): GetOfficesResponse
    {
        $httpRequest = $this->transformer->transform($request);
        $response = $this->client->request($httpRequest);

        $body = $this->getBody($response);

        return GetOfficesResponse::fromArray($body);
    }
}
