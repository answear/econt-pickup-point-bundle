<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Response;

use Answear\EcontBundle\Response\Struct\Office;
use Answear\EcontBundle\Response\Struct\OfficeCollection;
use Webmozart\Assert\Assert;

class GetOfficesResponse
{
    public function __construct(
        public OfficeCollection $offices,
    ) {
    }

    public function getOffices(): OfficeCollection
    {
        return $this->offices;
    }

    public static function fromArray(array $arrayResponse): self
    {
        Assert::keyExists($arrayResponse, 'offices');

        return new self(
            new OfficeCollection(
                array_map(
                    static fn($officeData) => Office::fromArray($officeData),
                    $arrayResponse['offices']
                )
            )
        );
    }
}
