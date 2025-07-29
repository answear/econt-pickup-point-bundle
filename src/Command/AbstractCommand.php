<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Command;

use Answear\EcontBundle\Client\Client;
use Answear\EcontBundle\Client\RequestTransformer;
use Answear\EcontBundle\Exception\MalformedResponseException;
use Answear\EcontBundle\Request\Request;
use Answear\EcontBundle\Response\ErrorResponse;
use Psr\Http\Message\ResponseInterface;
use Webmozart\Assert\Assert;

abstract readonly class AbstractCommand
{
    public function __construct(
        protected Client $client,
        protected RequestTransformer $transformer
    ) {
    }

    public function getResponse(Request $request): ResponseInterface
    {
        $httpRequest = $this->transformer->transform($request);

        return $this->client->request($httpRequest);
    }

    protected function getBody(ResponseInterface $response): array
    {
        try {
            $body = $response->getBody()->getContents();

            if (empty($body)) {
                throw new \RuntimeException('Empty response.');
            }
            $decoded = \json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            Assert::isArray($decoded);
        } catch (\Throwable $e) {
            throw new MalformedResponseException($e->getMessage(), $response, $e);
        }

        if (ErrorResponse::isErrorResponse($decoded)) {
            throw new MalformedResponseException('Error response', ErrorResponse::fromArray($decoded));
        }

        return $decoded;
    }
}
