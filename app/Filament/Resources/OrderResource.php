<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\OrderProductsRelationManager;

class OrderResource extends Resource
{
    const NAME = 'Заказы';
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Обратная связь';
    protected static ?string $navigationLabel = self::NAME;
    protected static ?string $pluralModelLabel = self::NAME;
    protected static ?string $modelLabel = 'Заказ';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Tabs::make('Основное')
                                ->tabs([
                                    Tab::make('Основные')
                                        ->schema([
                                            Section::make('Информация о заказе')
                                                ->schema([
                                                    Forms\Components\TextInput::make('id')
                                                        ->label('ID заказа')
                                                        ->disabled(),
                                                    Forms\Components\TextInput::make('name')
                                                        ->label('Имя'),
                                                    Forms\Components\TextInput::make('surname')
                                                        ->label('Фамилия'),
                                                    Forms\Components\TextInput::make('middle_name')
                                                        ->label('Отчество'),
                                                    Forms\Components\TextInput::make('phone')
                                                        ->label('Телефон')
                                                        ->required(),
                                                    Forms\Components\TextInput::make('email')
                                                        ->label('Email'),
                                                    Forms\Components\Textarea::make('message')
                                                        ->label('Комментарий'),
                                                    Forms\Components\Section::make('Данные о доставке')->schema([
                                                        Forms\Components\Placeholder::make('delivery_info')
                                                            ->label('Способ доставки')
                                                            ->content(fn ($record) => $record->delivery?->title ?? ''),
                                                        Forms\Components\Placeholder::make('payment_info')
                                                            ->label('Способ оплаты')
                                                            ->content(fn ($record) => PaymentType::find($record->payment_type_id)?->title ?? ''),
                                                        Forms\Components\TextInput::make('delivery_price')
                                                            ->label('Стоимость доставки')
                                                            ->disabled(),
                                                    ])->columns(3),
                                                    Forms\Components\Section::make('Адрес доставки')->schema([
                                                        Forms\Components\Placeholder::make('city')
                                                            ->label('Город')
                                                            ->content(fn ($record) => $record->city ?? ''),
                                                        Forms\Components\Placeholder::make('street')
                                                            ->label('Улица')
                                                            ->content(fn ($record) => $record->street ?? ''),
                                                        Forms\Components\Placeholder::make('house')
                                                            ->label('Дом')
                                                            ->content(fn ($record) => $record->house ?? ''),
                                                        Forms\Components\Placeholder::make('block')
                                                            ->label('Корпус')
                                                            ->content(fn ($record) => $record->block ?? ''),
                                                        Forms\Components\Placeholder::make('flat')
                                                            ->label('Квартира')
                                                            ->content(fn ($record) => $record->flat ?? ''),
                                                    ])->columns(3),                                
                                                    Forms\Components\TextInput::make('total_amount')
                                                        ->label('Сумма заказа')
                                                        ->disabled()
                                                        ->live()
                                                        ->afterStateUpdated(function ($state, $livewire) {
                                                            $livewire->dispatch('refreshProducts');
                                                        }),
                                                ])->columns(2),
                                        ]),
                                ])
                        ])
                ])->columnSpan(['lg' => 3])
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),                   
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->label('Сумма')
                    ->money('BYN')
                    ->sortable(),
                TextColumn::make('delivery_price')
                    ->label('Стоимость доставки')
                    ->money('BYN')
                    ->sortable(),
                TextColumn::make('delivery.title')
                    ->label('Способ доставки'),
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            OrderProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
