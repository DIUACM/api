<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TshirtSize: string implements HasLabel
{
    case XS = 'xs';
    case S = 's';
    case M = 'm';
    case L = 'l';
    case XL = 'xl';
    case XXL = 'xxl';
    case XXXL = 'xxxl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::XS => 'XS',
            self::S => 'S',
            self::M => 'M',
            self::L => 'L',
            self::XL => 'XL',
            self::XXL => 'XXL',
            self::XXXL => 'XXXL',
        };
    }
}
