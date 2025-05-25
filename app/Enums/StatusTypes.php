<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusTypes: int implements HasLabel, HasColor
{
    use EnumOptions, EnumValues;

    case Pending = 0;
    case Rejected = 1;
    case Accepted = 2;
    case Finished = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Accepted => 'مقبول',
            self::Rejected => 'مرفوض',
            self::Finished => 'تم الانتهاء',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'info',
            self::Rejected => 'danger',
            self::Accepted => 'warning',
            self::Finished => 'success',
        };
    }





    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function isPending(): bool
    {
        return $this === self::Pending;
    }

    public function isConfirmed(): bool
    {
        return $this === self::Accepted;
    }

    public function isRejected(): bool
    {
        return $this === self::Rejected;
    }
}
