<?php

namespace App\Enums;

enum SettingEnum: string
{
    use EnumToArray;

    case contacts = 'Контакты';
    case content = 'Контент';
    case metrics = 'Метрики/Скрипты';

    public static function valueOne($name)
    {
        foreach (self::cases() as $value) {
            if ($name === $value->name) {
                return $value->value;
            }
        }
    }
}
