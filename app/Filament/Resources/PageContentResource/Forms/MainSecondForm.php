<?php

namespace App\Filament\Resources\PageContentResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class MainSecondForm
{
    public static function get(): array
    {
        return [
            Section::make('')->schema([
                Repeater::make('data.blocks')
                    ->label('Блоки')
                    ->maxItems(4)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок'),
                        TextInput::make('desc')
                            ->label('Описание'),
                        FileUpload::make('svg')
                            ->label('Картинка svg 24x24')
                            ->directory('page_content'),
                    ]),
            ]),
        ];
    }
}
