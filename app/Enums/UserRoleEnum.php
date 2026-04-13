<?php

namespace App\Enums;

enum UserRoleEnum: int
{
    case ADMIN = 1;
    case USER = 2;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Админ',
            self::USER => 'Обычный пользователь',
        };
    }

    public static function options($name)
    {
        return match ($name) {
            self::ADMIN => 'Админ',
            self::USER => 'Обычный пользователь',
        };
    }
}
