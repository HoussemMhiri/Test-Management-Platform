<?php

namespace App\Enums;

enum QuestionTypeEnum: string
{
    use EnumHelpers;

    case CHOICES_SELECTION = 'Choices Selection';
    case CHOICES_ORDERING = 'Choices Ordering';
    case TEXT = 'Text';
    case ATTACHMENT = 'Attachment';
    case OTHER = 'Other';

    const TRANSLATION_FILE = '';

    public static function toSelectArray(): array
    {
        return self::list();
    }
}
