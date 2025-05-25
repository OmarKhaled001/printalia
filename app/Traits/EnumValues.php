<?php

namespace App\Traits;

trait EnumValues
{
    public static function values($value = 'value', $cases = null): array
    {
        if (!$cases) {
            $cases   = static::cases();
        }
        $options = [];
        foreach ($cases as $case) {
            $options[] = $case->$value;
        }
        return $options;
    }
}
