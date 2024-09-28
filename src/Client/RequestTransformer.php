<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Client;

use Answear\EcontBundle\ConfigProvider;
use Answear\EcontBundle\Request\Request;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Psr7\Uri;

readonly class RequestTransformer
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function transform(Request $request): HttpRequest
    {
        return new HttpRequest(
            $request->getMethod(),
            new Uri(ConfigProvider::SERVICE_URI . $request->getEndpoint()),
            [
                'Content-type' => 'application/json',
            ],
            $this->serializer->serialize($request)
        );
    }
}
