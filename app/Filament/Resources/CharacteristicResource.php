<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Enums\ChTypeEnum;
use Filament\Tables\Table;
use App\Models\Characteristic;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CharacteristicResource\Pages;
use App\Filament\Resources\CharacteristicResource\RelationManagers;

class CharacteristicResource extends Resource
{
    const NAME = 'Характеристики';
    protected static ?string $model = Characteristic::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Характеристика';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Тип')
                    ->options([
                        ChTypeEnum::CHECKBOX->value => 'Чекбокс',
                        ChTypeEnum::RANGE->value => 'Диапазон',
                    ])
                    ->required(),
            ])->columns(2),
            Forms\Components\Section::make('')->schema([
                Forms\Components\TextInput::make('measure')
                    ->label('Единица измерения')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pos')
                    ->label('Позиция (Опционально)')
                    ->default(1000),
            ])->columns(2),
            // Forms\Components\Section::make('')->schema([
            //     Forms\Components\Checkbox::make('in_filter')
            //         ->label('Фильтр'),
            //     Forms\Components\Checkbox::make('is_active')
            //         ->label('Активно'),
            // ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('categories.title')
                //     ->label('Категории')
                //     ->wrap()
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\CheckboxColumn::make('in_filter')
                //     ->label('Фильтр'),
                Tables\Columns\TextColumn::make('measure')
                    ->label('Единица измерения')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\CheckboxColumn::make('is_active')
                //     ->label('Активно'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCharacteristics::route('/'),
            'create' => Pages\CreateCharacteristic::route('/create'),
            'edit' => Pages\EditCharacteristic::route('/{record}/edit'),
        ];
    }
}
