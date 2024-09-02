<?php

namespace App\Enums;

enum GenderEnum: string
{
    use EnumHelpers;

    const TRANSLATION_FILE = "gender-enum";

    case FEMALE  = "FEMALE";
    case MALE  = "MALE";

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
