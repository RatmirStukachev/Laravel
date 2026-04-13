<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryResource extends Resource
{
    const NAME = 'Доставки';
    protected static ?string $model = Delivery::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Доставки';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название')
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('desc')
                            ->label('Описание')
                            ->maxLength(255),
                    ])->columns(2),
                    Forms\Components\Section::make('Диапазоны цен')
                    ->schema([
                        Forms\Components\Repeater::make('priceRanges')
                            ->label('Диапазоны цен')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\TextInput::make('from_sum')
                                            ->label('Сумма корзины от')
                                            ->numeric()
                                            ->required(),
                                        Forms\Components\TextInput::make('to_sum')
                                            ->label('Сумма корзины до')
                                            ->helperText('Оставьте пустым для максимального значения')
                                            ->numeric(),
                                        Forms\Components\TextInput::make('price')
                                            ->label('Цена доставки')
                                            ->numeric()
                                            ->required(),
                                    ]),
                            ])
                            ->orderColumn('pos')
                            ->defaultItems(1)
                            ->columnSpanFull(),
                    ]),
                Forms\Components\TextInput::make('pos')
                    ->label('Позиция (Опционально)')
                    ->columnSpanFull()
                    ->default(1000),
                Forms\Components\Checkbox::make('is_active')
                    ->label('Активно')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Название'),
                Tables\Columns\TextInputColumn::make('pos')->label('Позиция'),
                Tables\Columns\CheckboxColumn::make('is_active')->label('Активно'),
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
