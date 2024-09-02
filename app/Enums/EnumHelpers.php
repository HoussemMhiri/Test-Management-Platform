<?php

namespace App\Enums;

trait EnumHelpers
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function list($keyed_by_code = false)
    {
        $list = [];

        foreach (self::values() as $value) {
            $list[] = [
                'name' => trans(self::TRANSLATION_FILE . '' . $value),
                'code' => $value
            ];
        }

        return $keyed_by_code ? collect($list)->pluck('name', 'code')->toArray() : $list;
    }

    public function label()
    {
        return trans(self::TRANSLATION_FILE . '.' . $this->value);
    }
}
