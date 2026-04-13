<?php

namespace App\Filament\Resources\PageContentResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ProductDeliveryForm
{
    public static function get(): array
    {
        return [
            Section::make('')->schema([
                TextInput::make('data.title')
                    ->label('Заголовок (Доставка)'),
                TextInput::make('data.delivery')
                    ->label('Описание доставки'),
                TextInput::make('data.pickup')
                    ->label('Описание самовывоза'),
            ])->columns(3),
        ];
    }
}
