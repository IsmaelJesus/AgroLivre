<?php

namespace App\Enums;

enum SeedUnityEnum : string
{
    case QUILOS = 'Quilos';
    case TONELADAS = 'Toneladas';

    public function label(): string
    {
        return match ($this) {
            self::QUILOS => 'Kg',
            self::TONELADAS => 'T',
        };
    }
}
