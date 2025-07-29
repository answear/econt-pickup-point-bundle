<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Command;

use Answear\EcontBundle\Request\GetOfficesRequest;
use Answear\EcontBundle\Response\GetOfficesResponse;

readonly class GetOffices extends AbstractCommand
{
    public function getOffices(GetOfficesRequest $request): GetOfficesResponse
    {
        $body = $this->getBody($this->getResponse($request));

        return GetOfficesResponse::fromArray($body);
    }
}
