<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

readonly class OpeningHours
{
    private const MICROSECONDS_DIVIDER = 1000;

    public \DateTimeInterface $from;
    public \DateTimeInterface $to;

    public function __construct(int $from, int $to)
    {
        $this->from = \DateTimeImmutable::createFromFormat('U', (string) ($from / self::MICROSECONDS_DIVIDER));
        $this->to = \DateTimeImmutable::createFromFormat('U', (string) ($to / self::MICROSECONDS_DIVIDER));
    }
}
