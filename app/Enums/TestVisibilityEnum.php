<?php
namespace App\Enums;

enum TestVisibilityEnum: string
{
    use EnumHelpers;

    case PUBLIC = 'Public';
    case ONLY_INVITED = 'Only Invited';

    const TRANSLATION_FILE = '';

    public static function toSelectArray(): array
    {
        return self::list();
    }
}

