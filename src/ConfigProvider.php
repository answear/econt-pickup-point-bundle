<?php

declare(strict_types=1);

namespace Answear\EcontBundle;

readonly class ConfigProvider
{
    public const URL = 'http://ee.econt.com/';
    public const SERVICE_URI = '/services/Nomenclatures/';

    public function __construct(
        public string $user,
        public string $password,
    ) {
    }

    public function getRequestHeaders(): array
    {
        return [
            'base_uri' => self::URL,
            'auth' => [$this->user, $this->password],
        ];
    }
}
