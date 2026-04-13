<?php

namespace App\Filament\Resources\PageContentResource\Forms;

use Filament\Forms\Components\Section;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class CartDeliveryForm
{
    public static function get(): array
    {
        return [
            Section::make('')->schema([
                TinyEditor::make('data.content')
                    ->columnSpanFull()
                    ->label('Содержимое'),
            ])->columns(3),
        ];
    }
}
