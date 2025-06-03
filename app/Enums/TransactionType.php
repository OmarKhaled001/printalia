<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TransactionType: int implements HasLabel, HasColor
{
    use EnumOptions, EnumValues;

    case PROFIT = 0;     // ربح عادي
    case REFERRAL = 1;   // إحالة

    public function getLabel(): string
    {
        return match ($this) {
            self::PROFIT => 'ربح',
            self::REFERRAL => 'إحالة',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::REFERRAL => 'info',
            self::PROFIT => 'success',
        };
    }





    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
