<?php

namespace App\Enums;

enum TypeEnum : string
{
    case ADUBACAO = 'adubador';
    case COLHEITA = 'colheitadeira';
    case PLANTIO = 'plantadeira';
    case PULVERIZADOR = 'pulverizador';

    public function label(): string
    {
        return match ($this) {
            self::ADUBACAO => 'Adubação',
            self::COLHEITA => 'Colheita',
            self::PLANTIO => 'Plantio',
            self::PULVERIZADOR => 'Pulverização',
        };
    }
}
