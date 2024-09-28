<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Webmozart\Assert\Assert;

readonly class Country
{
    public function __construct(
        public ?int $id,
        public string $code2,
        public string $code3,
        public string $name,
        public string $nameEn,
        public bool $isEU,
    ) {
    }

    public static function fromArray(array $countryData): self
    {
        Assert::keyExists($countryData, 'id');
        Assert::keyExists($countryData, 'code2');
        Assert::keyExists($countryData, 'code3');
        Assert::keyExists($countryData, 'name');
        Assert::keyExists($countryData, 'nameEn');
        Assert::keyExists($countryData, 'isEU');

        return new self(
            $countryData['id'],
            $countryData['code2'],
            $countryData['code3'],
            $countryData['name'],
            $countryData['nameEn'],
            $countryData['isEU']
        );
    }
}
