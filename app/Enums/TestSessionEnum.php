<?php

namespace App\Enums;

enum TestSessionEnum: string
{
    use EnumHelpers;

    const TRANSLATION_FILE = "";

    case UPCOMING  = "Upcoming";
    case INPROGRESS  = "Inprogress";
    case DONE  = "Done";
}
