<?php

namespace App\Enums;

enum PlanLimitationTypeEnum: string
{
    use EnumHelpers;

    const TRANSLATION_FILE = 'plans_enum';

    case NUMBER = 'Number';
    case PAY_AS_YOU_GO = 'Pay as you go';
}
