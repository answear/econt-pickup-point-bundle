<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response\Struct;

use Answear\EcontBundle\Enum\OfficeType;
use Answear\EcontBundle\Enum\ShipmentType;
use Webmozart\Assert\Assert;

readonly class Office
{
    public OfficeType $officeType;

    /**
     * @param string[] $phones
     * @param string[] $emails
     * @param ShipmentType[] $shipmentTypes
     */
    public function __construct(
        public int $id,
        public string $code,
        public bool $isMPS,
        public bool $isAPS,
        public string $name,
        public string $nameEn,
        public array $phones,
        public array $emails,
        public OfficeAddress $address,
        public string $info,
        public string $currency,
        public ?string $language,
        public ?OpeningHours $openingHours,
        public ?OpeningHours $halfDayOpeningHours,
        public array $shipmentTypes,
        public bool $cardPaymentAllowed,
        public string $partnerCode,
        public string $hubCode,
        public string $hubName,
        public string $hubNameEn,
    ) {
        if ($isAPS) {
            $this->officeType = OfficeType::Aps;
        } elseif ($isMPS) {
            $this->officeType = OfficeType::Mps;
        } else {
            $this->officeType = OfficeType::Office;
        }
    }

    public static function fromArray(array $officeData): self
    {
        Assert::integer($officeData['id']);
        Assert::stringNotEmpty($officeData['code']);
        Assert::boolean($officeData['isMPS']);
        Assert::boolean($officeData['isAPS']);
        Assert::stringNotEmpty($officeData['name']);
        Assert::stringNotEmpty($officeData['nameEn']);
        Assert::allString($officeData['phones']);
        Assert::allString($officeData['emails']);
        Assert::string($officeData['info']);
        Assert::stringNotEmpty($officeData['currency']);
        Assert::nullOrString($officeData['language']);
        Assert::nullOrInteger($officeData['normalBusinessHoursFrom']);
        Assert::nullOrInteger($officeData['normalBusinessHoursTo']);
        Assert::nullOrInteger($officeData['halfDayBusinessHoursFrom']);
        Assert::nullOrInteger($officeData['halfDayBusinessHoursTo']);
        Assert::string($officeData['partnerCode']);
        Assert::stringNotEmpty($officeData['hubCode']);
        Assert::stringNotEmpty($officeData['hubName']);
        Assert::stringNotEmpty($officeData['hubNameEn']);

        return new self(
            $officeData['id'],
            $officeData['code'],
            $officeData['isMPS'],
            $officeData['isAPS'],
            $officeData['name'],
            $officeData['nameEn'],
            $officeData['phones'],
            $officeData['emails'],
            OfficeAddress::fromArray($officeData['address']),
            $officeData['info'],
            $officeData['currency'],
            $officeData['language'],
            self::guessOpeningHours($officeData),
            self::guessHalfDayOpeningHours($officeData),
            self::guessShipmentTypes($officeData),
            true,
            $officeData['partnerCode'],
            $officeData['hubCode'],
            $officeData['hubName'],
            $officeData['hubNameEn'],
        );
    }

    private static function guessOpeningHours(array $officeData): ?OpeningHours
    {
        if (null !== $officeData['normalBusinessHoursFrom'] && null !== $officeData['normalBusinessHoursTo']) {
            return new OpeningHours(
                $officeData['normalBusinessHoursFrom'],
                $officeData['normalBusinessHoursTo']
            );
        }

        return null;
    }

    private static function guessHalfDayOpeningHours(array $officeData): ?OpeningHours
    {
        if (null !== $officeData['halfDayBusinessHoursFrom'] && null !== $officeData['halfDayBusinessHoursTo']) {
            return new OpeningHours(
                $officeData['halfDayBusinessHoursFrom'],
                $officeData['halfDayBusinessHoursTo']
            );
        }

        return null;
    }

    /**
     * @return ShipmentType[] array
     */
    private static function guessShipmentTypes(array $officeData): array
    {
        return array_map(
            static function (string $type) {
                try {
                    return ShipmentType::from($type);
                } catch (\ValueError) {
                    // NOP, do not fail hard for new services
                }
            },
            $officeData['shipmentTypes']
        );
    }
}
