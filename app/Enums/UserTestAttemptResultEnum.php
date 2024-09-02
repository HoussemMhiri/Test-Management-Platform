<?php

namespace App\Enums;

enum UserTestAttemptResultEnum: string
{
    use EnumHelpers;

    const TRANSLATION_FILE = "user-test-attempt-result-enum";

    case PASSED  = "Passed";
    case FAILED  = "Failed";

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
