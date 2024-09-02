<?php

namespace App\Enums;

enum QuestionSelectionEnum: string
{
    use EnumHelpers;

    case RANDOM = 'Random';
    case FIXED = 'Fixed';

    const TRANSLATION_FILE = '';

    public static function toSelectArray(): array
    {
        return self::list();
    }
}
