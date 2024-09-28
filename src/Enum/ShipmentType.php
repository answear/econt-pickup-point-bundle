<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Enum;

enum ShipmentType: string
{
    case Document = 'document';
    case Pack = 'pack';
    case PostPack = 'post_pack';
    case Pallet = 'pallet';
    case Cargo = 'cargo';
    case DocumentPallet = 'documentpallet';
    case BitLetter = 'big_letter';
    case SmallLetter = 'small_letter';
    case MoneyTransfer = 'money_transfer';
    // additional types found
    case Courier = 'courier';
    case Post = 'post';
}
