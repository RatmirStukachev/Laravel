<?php

namespace App\Filament\Resources\PageContentResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MainSlideForm
{
    public static function get(): array
    {
        return [
            Section::make('')->schema([
                TextInput::make('data.link')
                    ->columnSpanFull()
                    ->label('Ссылка слайда'),
                FileUpload::make('data.image')
                    ->label('Картинка (1360x285)')
                    ->required()
                    ->columnSpanFull()
                    ->image()
                    ->directory('page_content'),
            ]),
        ];
    }
}
