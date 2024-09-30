<?php

declare(strict_types=1);

namespace Answear\EcontBundle\Enum;

enum OfficeType: string
{
    case Office = 'office';
    case Aps = 'aps';
    case Mps = 'mps';
}
