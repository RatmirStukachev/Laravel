<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\CustomerEnum;
use App\Models\PaymentType;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentTypeResource\Pages;
use App\Filament\Resources\PaymentTypeResource\RelationManagers;

class PaymentTypeResource extends Resource
{
    const NAME = 'Способы оплаты';
    protected static ?string $model = PaymentType::class;
    protected static ?string $navigationGroup = 'Магазин';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Способ оплаты';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('')
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
                    // Forms\Components\FileUpload::make('svg')
                    // ->label('Иконка (svg)')
                    // ->columnSpanFull()
                    // ->acceptedFileTypes(['image/svg+xml']),
                    Forms\Components\TextInput::make('pos')
                        ->label('Позиция')
                        ->default(1000)
                        ->columnSpanFull(),
                    Forms\Components\Checkbox::make('is_active')
                        ->label('Активно'),                              
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Способ оплаты'),
                TextInputColumn::make('pos')
                    ->label('Позиция'),
                CheckboxColumn::make('is_active')
                    ->label('Активен'),
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
            'index' => Pages\ListPaymentTypes::route('/'),
            'create' => Pages\CreatePaymentType::route('/create'),
            'edit' => Pages\EditPaymentType::route('/{record}/edit'),
        ];
    }
}
