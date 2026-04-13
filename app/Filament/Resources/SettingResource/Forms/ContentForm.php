<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ContentForm
{
    const NAME = 'Контент';
    const ICON = 'heroicon-o-document-text';
    public static function get(): array
    {
        return [
            TextInput::make('copyright')->label('Копирайты'),
            TextInput::make('privacy')->label('Ссылка на политику обработки персональных данных'),
            TextInput::make('public_offerta')->label('Ссылка на публичную оферту'),
            TextInput::make('products_count')->label('Кол-во товаров на странице'),
            TextInput::make('news_count')->label('Кол-во новостей на странице'),
            TextInput::make('articles_count')->label('Кол-во статей на странице'),
            TextInput::make('yandex_api')->label('Yandex api key'),
        ];
    }
}
