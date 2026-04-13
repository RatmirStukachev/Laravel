<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MetricsForm
{
    const NAME = 'Метрики/скрипты';
    const ICON = 'heroicon-o-document-text';

    public static function get(): array
    {
        return [
            Textarea::make('head')->label('Вставка в секцию head'),
            Textarea::make('body_start')->label('Вставка в начало секции body'),
            Textarea::make('body_end')->label('Вставка в конец секции body'),
            TextInput::make('yandex_api')->label('Yandex api key'),
        ];
    }
}
