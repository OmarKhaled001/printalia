<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait EnumOptions
{
    public static function options($cases = null): array
    {
        if (!$cases) {
            $cases = static::cases();
        }
        $options = [];
        foreach ($cases as $case) {
            $label = $case->name;
            if (Str::contains($label, '_')) {
                $label = Str::replace('_', ' ', $label);
            }
            $options[] = [
                'value' => $case->value,
                'label' => Str::title($label)
            ];
        }
        return $options;
    }

    public static function array(): array
    {
        return array_combine(
            array_map(fn($case) => $case->value, static::cases()),
            array_map(fn($case) => __(Str::title(Str::replace('_', ' ', $case->name))), static::cases())
        );
    }

    /**
     * Retrieve a map of enum keys and values.
     *
     * @return array
     */
    public static function toArray($cases = null): array
    {
        if (!$cases) {
            $cases = self::cases();
        }
        $array = [];
        foreach ($cases as $case) {
            $array[$case->name] = __($case->value);
        }
        return $array;
    }

}
