<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Command;

use Answear\EcontBundle\Request\GetCitiesRequest;
use Answear\EcontBundle\Response\GetCitiesResponse;

readonly class GetCities extends AbstractCommand
{
    public function getCities(GetCitiesRequest $request): GetCitiesResponse
    {
        $body = $this->getBody($this->getResponse($request));

        return GetCitiesResponse::fromArray($body);
    }
}
