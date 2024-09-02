<?php

namespace App\Enums;

use App\Enums\EnumHelpers;

enum EvaluationEnum: string
{
    use EnumHelpers;

    case ALL_CORRECT = 'All Correct';
    case MIXED = 'Mixed';

    const TRANSLATION_FILE = "";

    public static function toSelectArray(): array
    {
        return self::list();
    }
}
