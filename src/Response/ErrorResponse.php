<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response;

use Webmozart\Assert\Assert;

readonly class ErrorResponse
{
    /**
     * @param string[] $fields
     * @param ErrorResponse[]|null $innerErrors
     */
    public function __construct(
        public string $message,
        public string $type,
        public array $fields,
        public ?array $innerErrors,
    ) {
    }

    public static function isErrorResponse(array $response): bool
    {
        return isset($response['error']);
    }

    public static function fromArray(array $response): self
    {
        if (!self::isErrorResponse($response)) {
            throw new \RuntimeException('Cannot create ErrorResponse');
        }

        $response = $response['error'];

        Assert::keyExists($response, 'message');
        Assert::keyExists($response, 'type');
        Assert::keyExists($response, 'fields');
        Assert::keyExists($response, 'innerErrors');

        return new self($response['message'], $response['type'], $response['fields'], $response['innerErrors']);
    }
}
