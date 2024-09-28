<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Webmozart\Assert\Assert;

readonly class City
{
    public function __construct(
        public int $id,
        public Country $country,
        public string $postalCode,
        public string $name,
        public string $nameEn,
        public ?string $regionName,
        public ?string $regionNameEn,
        public ?string $phoneCode,
        public ?Coordinates $coordinates,
        public ?bool $expressDeliveries,
    ) {
    }

    public static function fromArray(array $cityData): self
    {
        Assert::keyExists($cityData, 'id');
        Assert::keyExists($cityData, 'country');
        Assert::keyExists($cityData, 'postCode');
        Assert::keyExists($cityData, 'name');
        Assert::keyExists($cityData, 'nameEn');
        Assert::keyExists($cityData, 'regionName');
        Assert::keyExists($cityData, 'regionNameEn');
        Assert::keyExists($cityData, 'regionNameEn');
        Assert::keyExists($cityData, 'phoneCode');
        Assert::keyExists($cityData, 'expressCityDeliveries');

        return new self(
            $cityData['id'],
            Country::fromArray($cityData['country']),
            $cityData['postCode'],
            $cityData['name'],
            $cityData['nameEn'],
            $cityData['regionName'],
            $cityData['regionNameEn'],
            $cityData['phoneCode'],
            Coordinates::fromArray($cityData['location'] ?? []),
            $cityData['expressCityDeliveries']
        );
    }
}
