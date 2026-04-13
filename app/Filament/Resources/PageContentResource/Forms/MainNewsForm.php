<?php

namespace App\Filament\Resources\PageContentResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MainNewsForm
{
    public static function get(): array
    {
        return [
            Section::make('')->schema([
                TextInput::make('data.title')
                    ->columnSpanFull()
                    ->label('Заголовок (Наши новости)'),
            ])->columns(2),
        ];
    }
}
