<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Exception;

use Answear\EcontBundle\Response\ErrorResponse;

class MalformedResponseException extends \RuntimeException
{
    /**
     * @param ErrorResponse|mixed $response
     */
    public function __construct(
        string $message,
        public $response,
        ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
