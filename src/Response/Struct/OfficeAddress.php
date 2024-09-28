<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Webmozart\Assert\Assert;

readonly class OfficeAddress
{
    public function __construct(
        public ?int $id,
        public City $city,
        public string $fullAddress,
        public ?string $quarter,
        public ?string $street,
        public ?string $num,
        public string $other,
        public ?Coordinates $coordinates,
        public ?string $postalCode,
    ) {
    }

    public static function fromArray(array $addressData): self
    {
        Assert::keyExists($addressData, 'id');
        Assert::keyExists($addressData, 'city');
        Assert::keyExists($addressData, 'fullAddress');
        Assert::keyExists($addressData, 'quarter');
        Assert::keyExists($addressData, 'street');
        Assert::keyExists($addressData, 'num');
        Assert::keyExists($addressData, 'other');
        Assert::keyExists($addressData, 'location');
        Assert::keyExists($addressData, 'zip');

        return new self(
            $addressData['id'],
            City::fromArray($addressData['city']),
            $addressData['fullAddress'],
            $addressData['quarter'],
            $addressData['street'],
            $addressData['num'],
            $addressData['other'],
            Coordinates::fromArray($addressData['location']),
            $addressData['zip']
        );
    }
}
