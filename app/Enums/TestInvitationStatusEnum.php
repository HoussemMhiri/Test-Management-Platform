<?php

namespace App\Enums;

enum TestInvitationStatusEnum: string
{
    use EnumHelpers;

    const TRANSLATION_FILE = "test-invitation-status-enum";

    case PENDING  = "PENDING";
    case ACCEPTED  = "ACCEPTED";
    case EXPIRED  = "EXPIRED";
    case DECLINED  = "DECLINED";

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
